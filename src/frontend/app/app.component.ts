import { Component, ViewChild, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { DomSanitizer } from '@angular/platform-browser';
import { MatIconRegistry } from '@angular/material/icon';
import { MAT_TOOLTIP_DEFAULT_OPTIONS, MatTooltipDefaultOptions } from '@angular/material/tooltip';
import { HeaderService } from '../service/header.service';
import { AppService } from '../service/app.service';
import { MatSidenav } from '@angular/material/sidenav';
import { LangService } from '../service/app-lang.service';
import { Router } from '@angular/router';

/** Custom options the configure the tooltip's default show/hide delays. */
export const myCustomTooltipDefaults: MatTooltipDefaultOptions = {
    showDelay: 500,
    hideDelay: 0,
    touchendHideDelay: 0,
};

@Component({
    selector: 'app-root',
    templateUrl: 'app.component.html',
    viewProviders: [MatIconRegistry],
    providers: [
        AppService,
        { provide: MAT_TOOLTIP_DEFAULT_OPTIONS, useValue: myCustomTooltipDefaults }
    ],
})
export class AppComponent implements OnInit {

    @ViewChild('snavLeft', { static: false }) snavLeft: MatSidenav;

    constructor(
        public langService: LangService,
        private location: Location,
        iconReg: MatIconRegistry,
        sanitizer: DomSanitizer,
        public appService: AppService,
        public headerService: HeaderService
    ) {

        iconReg.addSvgIcon('maarchLogo', sanitizer.bypassSecurityTrustResourceUrl('static.php?filename=logo_white.svg')).addSvgIcon('maarchLogoOnly', sanitizer.bypassSecurityTrustResourceUrl('img/logo_only_white.svg'));
        iconReg.addSvgIcon('maarchLogoFull', sanitizer.bypassSecurityTrustResourceUrl('assets/logo.svg'));
        iconReg.addSvgIcon('maarchLogoWhite', sanitizer.bypassSecurityTrustResourceUrl('assets/logo_white.svg'));
        iconReg.addSvgIcon('maarchBox', sanitizer.bypassSecurityTrustResourceUrl('assets/maarch_box.svg'));

    }

    ngOnInit(): void {

        this.headerService.hideSideBar = true;
        setTimeout(() => {
            this.headerService.sideNavLeft = this.snavLeft;
        }, 0);

        this.headerService.sideNavLeft = this.snavLeft;
    }
}
