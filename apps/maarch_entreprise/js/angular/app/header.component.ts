import { Component, OnInit } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';

declare function $j(selector: any) : any;

declare var angularGlobals : any;


@Component({
    selector: 'menu-app',
    templateUrl :   angularGlobals["headerView"],
    styleUrls   :   [
                        'css/header.component.css', //load specific custom css
                        '../../node_modules/bootstrap/dist/css/bootstrap.min.css' //load bootstrap css
                    ]
})
export class HeaderComponent implements OnInit {

    coreUrl                     : string;

    lang                        : any       = {};
    table                       : any

    resultInfo                  : string    = "";
    loading                     : boolean   = false;


    constructor(public http: Http) {
    }

    prepareHeader() {
        $j('#header').remove();
    }

    ngOnInit(): void {
        this.prepareHeader();
        
        this.coreUrl = angularGlobals.coreUrl;

        this.loading = true;

    }
}
