import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';
import { Input, EventEmitter, Output, ViewChild, ElementRef } from '@angular/core';
import { Observable, of, forkJoin } from 'rxjs';
import { map, startWith, debounceTime, filter, distinctUntilChanged, switchMap, tap, exhaustMap, catchError } from 'rxjs/operators';
import { LatinisePipe } from 'ngx-pipes';
import { LANG } from '../../app/translate.component';
import { HttpClient } from '@angular/common/http';
import { ConfirmComponent } from '../modal/confirm.component';
import { NotificationService } from '../../app/notification.service';
import { MatDialog, MatDialogRef } from '@angular/material';

@Component({
    selector: 'plugin-autocomplete',
    templateUrl: 'autocomplete.component.html',
    styleUrls: ['autocomplete.component.scss', '../../app/indexation/indexing-form/indexing-form.component.scss'],
})
export class PluginAutocomplete implements OnInit {
    lang: any = LANG;
    myControl = new FormControl();
    loading = false;

    listInfo: string;

    type = {
        user: 'fa-user',
        entity: 'fa-sitemap'
    }

    /**
     * Can be used for real input or discret input filter
     * @default default
     * 
     * @param default
     * @param small
     */
    @Input('size') size: string;

    /**
     * If false, input auto empty when trigger a value
     */
    @Input('singleMode') singleMode: boolean;

    /**
     * Appearance of input
     * @default legacy
     * 
     * @param legacy
     * @param outline
     */
    @Input('appearance') appearance: string;


    @Input('required') required: boolean;

    /**
     * Datas of options in autocomplete. Incompatible with @routeDatas
     */
    @Input('datas') options: any;

    /**
     * Route datas used in async autocomplete. Incompatible with @datas
     */
    @Input('routeDatas') routeDatas: string[];

    /**
     * Placeholder used in input
     */
    @Input('labelPlaceholder') placeholder: string;

    /**
     * DEPRECATED
     */
    @Input('labelList') optGroupLabel: string;

    /**
     * Key of targeted info used when typing in input (ex : $data[0] = {id: 1, label: 'Jean Dupond'}; targetSearchKey => label)
     */
    @Input('targetSearchKey') key: string;

    /**
     * Key of sub info in display (ex : $data[0] = {id: 1, label: 'Jean Dupond', entity: 'Pôle social'}; subInfoKey => entity)
     */
    @Input('subInfoKey') subInfoKey: string;

    /**
     * FormControl used when autocomplete is used in form and must be catched in a form control.
     */
    @Input('control') controlAutocomplete: FormControl;

    /**
     * Route used for set values / adding / deleting item in BDD (DataModel must return id and label)
     */
    @Input('manageDatas') manageDatas: string;

    /**
     * Catch external event after select an element in autocomplete
     */
    @Output('triggerEvent') selectedOpt = new EventEmitter();

    @ViewChild('autoCompleteInput', { static: true }) autoCompleteInput: ElementRef;

    filteredOptions: Observable<string[]>;
    valuesToDisplay: any = {};

    dialogRef: MatDialogRef<any>;

    constructor(
        public http: HttpClient,
        private notify: NotificationService,
        public dialog: MatDialog,
        private latinisePipe: LatinisePipe
    ) { }

    ngOnInit() {
        this.appearance = this.appearance === undefined ? 'legacy' : 'outline';
        this.singleMode = this.singleMode === undefined ? false : true;
        this.optGroupLabel = this.optGroupLabel === undefined ? this.lang.availableValues : this.optGroupLabel;
        this.placeholder = this.placeholder === undefined ? this.lang.chooseValue : this.placeholder;

        if (this.controlAutocomplete !== undefined) {
            this.controlAutocomplete.setValue(this.controlAutocomplete.value === null || this.controlAutocomplete.value === '' ? [] : this.controlAutocomplete.value);
            this.initFormValue();
        }

        this.size = this.size === undefined ? 'default' : this.size;

        if (this.routeDatas !== undefined) {
            this.initAutocompleteRoute();
        } else {
            this.initAutocompleteData();
        }
    }

    initAutocompleteData() {
        this.listInfo = this.lang.noAvailableValue;
        this.filteredOptions = this.myControl.valueChanges
            .pipe(
                startWith(''),
                map(value => this._filter(value))
            );
    }

    initAutocompleteRoute() {
        this.listInfo = this.lang.autocompleteInfo;
        this.options = [];
        this.myControl.valueChanges
            .pipe(
                debounceTime(300),
                filter(value => value.length > 2),
                distinctUntilChanged(),
                tap(() => this.loading = true),
                switchMap((data: any) => this.getDatas(data)),
                tap((data: any) => {
                    if (data.length === 0) {
                        if (this.manageDatas !== undefined) {
                            this.listInfo = this.lang.noAvailableValue + ' <div>' + this.lang.typeEnterToCreate + '</div>';
                        } else {
                            this.listInfo = this.lang.noAvailableValue;
                        }
                    } else {
                        this.listInfo = '';
                    }
                    this.options = data;
                    this.filteredOptions = of(this.options);
                    this.loading = false;
                })
            ).subscribe();
    }

    getDatas(data: string) {
        let arrayObs: any = [];
        let test: any = [];
        this.routeDatas.forEach(element => {
            arrayObs.push(this.http.get('../..' + element, { params: { "search": data } }));
        });

        return forkJoin(arrayObs).pipe(
            map(data => {
                data.forEach((element: any) => {
                    element.forEach((element2: any) => {
                        test.push(element2);
                    });
                });
                return test;
            })
        );
    }

    selectOpt(ev: any) {
        if (this.singleMode) {
            this.myControl.setValue(ev.option.value[this.key]);
        } else if (this.controlAutocomplete !== undefined) {
            this.setFormValue(ev.option.value);
        }

        if (this.selectedOpt !== undefined) {
            this.resetAutocomplete();
            this.autoCompleteInput.nativeElement.blur();
            this.selectedOpt.emit(ev.option.value);
        }
    }

    initFormValue() {

        this.controlAutocomplete.value.forEach((ids: any) => {
            this.http.get('../..' + this.manageDatas + '/' + ids).pipe(
                tap((data) => {
                    for (var key in data) {
                        this.valuesToDisplay[data[key].id] = data[key].label;
                    }
                })
            ).subscribe();
        });
    }

    setFormValue(item: any) {
        if (this.controlAutocomplete.value.indexOf(item['id']) === -1) {
            let arrvalue = [];
            if (this.controlAutocomplete.value !== null) {
                arrvalue = this.controlAutocomplete.value;
            }
            arrvalue.push(item['id']);
            this.valuesToDisplay[item['id']] = item[this.key];
            this.controlAutocomplete.setValue(arrvalue);
        }
    }

    resetAutocomplete() {
        if (this.singleMode === false) {
            this.myControl.setValue('');
        }
        if (this.routeDatas !== undefined) {
            this.options = [];
            this.listInfo = this.lang.autocompleteInfo;
        }
    }

    private _filter(value: string): string[] {
        if (typeof value === 'string') {
            const filterValue = this.latinisePipe.transform(value.toLowerCase());
            return this.options.filter((option: any) => this.latinisePipe.transform(option[this.key].toLowerCase()).includes(filterValue));
        } else {
            return this.options;
        }
    }

    unsetValue() {
        this.controlAutocomplete.setValue('');
        this.myControl.setValue('');
        this.myControl.enable();
    }

    removeItem(index: number) {
        let arrValue = this.controlAutocomplete.value;
        arrValue.splice(index, 1);
        this.controlAutocomplete.setValue(arrValue);
    }

    addItem() {
        if (this.manageDatas !== undefined) {
            const newElem = {};

            newElem[this.key] = this.myControl.value;

            this.dialogRef = this.dialog.open(ConfirmComponent, { autoFocus: false, disableClose: true, data: { title: this.lang.confirm, msg: 'Voulez-vous créer cet élément <b>' + newElem[this.key] + '</b>&nbsp;?' } });

            this.dialogRef.afterClosed().pipe(
                filter((data: string) => data === 'ok'),
                exhaustMap(() => this.http.post('../..' + this.manageDatas, { label: newElem[this.key] })),
                tap((data: any) => {
                    for (var key in data) {
                        newElem['id'] = data[key];
                    }
                    this.setFormValue(newElem);
                    this.notify.success(this.lang.elementAdded);
                }),
                catchError((err: any) => {
                    this.notify.handleErrors(err);
                    return of(false);
                })
            ).subscribe();
        }
    }
    
    getValue() {
        return this.myControl.value;
    }

    resetValue() {
        return this.myControl.setValue('');
    }
}