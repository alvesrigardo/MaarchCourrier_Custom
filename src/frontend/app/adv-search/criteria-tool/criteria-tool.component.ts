import { Component, OnInit, ViewChild, ElementRef, EventEmitter, Output, Input } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { LANG } from '../../translate.component';
import { AppService } from '../../../service/app.service';
import { FunctionsService } from '../../../service/functions.service';
import { Observable } from 'rxjs';
import { FormControl } from '@angular/forms';
import { startWith, map } from 'rxjs/operators';
import { LatinisePipe } from 'ngx-pipes';
import { MatExpansionPanel } from '@angular/material/expansion';

@Component({
    selector: 'app-criteria-tool',
    templateUrl: "criteria-tool.component.html",
    styleUrls: ['criteria-tool.component.scss']
})
export class CriteriaToolComponent implements OnInit {

    lang: any = LANG;

    criteria: any = {
        mailInformations: [
            {
                id : 'resourceField',
                label: this.lang.criteriaResourceField,
                desc: this.lang.criteriaResourceFieldDesc,
                control : new FormControl()
            },
            {
                id : 'contactField',
                label: this.lang.criteriaContactField,
                desc: this.lang.criteriaContactFieldDesc,
                control : new FormControl()
            },
        ]
    }

    currentCriteria: any = [];

    filteredCriteria: any = {};

    searchCriteria = new FormControl();

    @Input() defaultCriteria: any = [];

    @Output() searchUrlGenerated = new EventEmitter<string>();

    @ViewChild('criteriaTool', { static: false }) criteriaTool: MatExpansionPanel;
    @ViewChild('searchCriteriaInput', { static: false }) searchCriteriaInput: ElementRef;

    constructor(
        public http: HttpClient,
        public appService: AppService,
        public functions: FunctionsService,
        private latinisePipe: LatinisePipe) { }

    ngOnInit(): void {

        Object.keys(this.criteria).forEach(keyVal => {
            this.criteria[keyVal].forEach((element: any) => {
                if (this.defaultCriteria.indexOf(element.id) > -1) {
                    this.currentCriteria.push(element);
                }
            });
            this.filteredCriteria[keyVal] = {};
            this.filteredCriteria[keyVal] = new Observable<string[]>();
            this.filteredCriteria[keyVal] = this.searchCriteria.valueChanges
            .pipe(
                startWith(''),
                map(value => this._filter(value, keyVal))
            );
        });
    }

    private _filter(value: string, type: string): string[] {
        if (typeof value === 'string') {
            const filterValue = this.latinisePipe.transform(value.toLowerCase());
            return this.criteria[type].filter((option: any) => this.latinisePipe.transform(option['label'].toLowerCase()).includes(filterValue));
        } else {
            return this.criteria[type];
        }
    }

    isCurrentCriteria(criteriaId: string) {
        return this.currentCriteria.filter((currCrit: any) => currCrit.id === criteriaId).length > 0;
    }

    addCriteria(criteria: any) {
        this.currentCriteria.push(criteria);
        this.searchCriteria.reset();
        this.searchCriteriaInput.nativeElement.blur();
    }

    removeCriteria(index: number) {
        this.currentCriteria.splice(index, 1);
    }

    getSearchUrl() {
        let arrUrl: any[] = [];
        this.currentCriteria.forEach((crit: any) => {
            if (!this.functions.empty(crit.control.value)) {
                arrUrl.push(`${crit.id}=${crit.control.value}`);
            }
        });
        this.criteriaTool.close();
        this.searchUrlGenerated.emit('&' + arrUrl.join('&'));
    }
}