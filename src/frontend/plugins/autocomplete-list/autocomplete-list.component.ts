import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';
import { Input, EventEmitter, Output, ViewChild, ElementRef } from '@angular/core';
import { map, startWith } from 'rxjs/operators';
import { LatinisePipe } from 'ngx-pipes';
import { LANG } from '../../app/translate.component';
import { HttpClient } from '@angular/common/http';
import { MatDialog, MatDialogRef } from '@angular/material/dialog';
import { MatChipInputEvent } from '@angular/material/chips';
import { MatAutocomplete, MatAutocompleteSelectedEvent } from '@angular/material/autocomplete';
import { Observable } from 'rxjs/internal/Observable';
import { NotificationService } from '../../service/notification/notification.service';

@Component({
    selector: 'app-autocomplete-list',
    templateUrl: 'autocomplete-list.component.html',
    styleUrls: ['autocomplete-list.component.scss'],
})
export class AutocompleteListComponent implements OnInit {
    lang: any = LANG;
    inputFormControl = new FormControl();
    loading = false;

    listInfo: string;

    /**
     * Appearance of input
     * @default legacy
     *
     * @param legacy
     * @param outline
     */
    @Input() appearance: string = 'legacy';


    @Input() required: boolean = false;

    /**
     * Options of options in autocomplete.
     */
    @Input() options: any = [];


    /**
     * Placeholder used in input
     */
    @Input() inputLabel: string = 'Mon champ';


    /**
     * Key of targeted info used when typing in input (ex : $data[0] = {id: 1, label: 'Jean Dupond'}; targetSearchKey => label)
     */
    @Input() targetSearchKey: string = null;


    /**
     * FormControl used when autocomplete is used in form and must be catched in a form control.
     */
    @Input() datasFormControl: FormControl  = new FormControl({ value: [], disabled: false });


    /**
     * Catch external event after select an element in autocomplete
     */
    @Output() afterSelected = new EventEmitter();

    @ViewChild('acInput') acInput: ElementRef<HTMLInputElement>;
    @ViewChild('auto') matAutocomplete: MatAutocomplete;

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
        // this.initAutocompleteData();
        console.log(Object.keys(this.options[0]));

        if (this.datasFormControl.value.length > 0 ) {
        
        }
    }

    getLabel(option: any) {
        if (this.options.length > 0 && Object.keys(this.options[0].length === 2)) {
            return option[this.targetSearchKey];
        } else {
            return option;
        }
    }

    initAutocompleteData() {
        this.filteredOptions = this.inputFormControl.valueChanges.pipe(
            startWith(null),
            map((fruit: string | null) => fruit ? this._filter(fruit) : this.options.slice()));
    }

    add(event: MatChipInputEvent): void {
        const input = event.input;
        const value = event.value;

        // Add our fruit
        if ((value || '').trim()) {
            this.datasFormControl.value.push(value.trim());
        }

        // Reset the input value
        if (input) {
            input.value = '';
        }

        this.inputFormControl.setValue(null);
    }

    remove(option: string): void {
        console.log(option);
        
        const index = this.datasFormControl.value.indexOf(option);

        if (index >= 0) {
            let arrvalue = [];
            arrvalue = this.datasFormControl.value;
            arrvalue.splice(index, 1);
            this.datasFormControl.setValue(arrvalue);
        }
    }

    selected(event: MatAutocompleteSelectedEvent): void {
        this.datasFormControl.value.push(event.option.viewValue);
        this.acInput.nativeElement.value = '';
        this.inputFormControl.setValue(null);
    }

    private _filter(value: string): string[] {
        const filterValue = value.toLowerCase();

        return this.datasFormControl.value.filter((data: any) => data.toLowerCase().indexOf(filterValue) > -1);
    }
}
