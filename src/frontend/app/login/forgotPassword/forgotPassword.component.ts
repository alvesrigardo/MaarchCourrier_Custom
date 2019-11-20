import { Component, OnInit } from '@angular/core';
import { DomSanitizer } from '@angular/platform-browser';
import { MatIconRegistry } from '@angular/material';
import { HttpClient } from '@angular/common/http';
import { NotificationService } from '../../notification.service';
import { finalize } from 'rxjs/operators';
import { LANG } from '../../translate.component';

declare function $j(selector: any) : any;

@Component({
    templateUrl: 'forgotPassword.component.html',
    styleUrls: ['forgotPassword.component.scss'],
})
export class ForgotPasswordComponent implements OnInit {

    lang: any = LANG;
    loadingForm: boolean = false;
    loading: boolean = false;
    newLogin: any = {
        login: ''
    };
    labelButton: string = this.lang.send;

    constructor(public http: HttpClient, iconReg: MatIconRegistry, sanitizer: DomSanitizer, public notificationService: NotificationService) {
        iconReg.addSvgIcon('maarchLogo', sanitizer.bypassSecurityTrustResourceUrl('static.php?filename=logo_white.svg'));
        $j('#bodyloginCustom').remove();
        $j('main-header').remove();
    }

    ngOnInit(): void { 
        $j('#bodyloginCustom').remove();
        $j('main-header').remove();
    }

    generateLink() {
        this.labelButton = this.lang.generation;
        this.loading = true;

        this.http.post('../../rest/password', { 'login': this.newLogin.login })
            .pipe(
                finalize(() => {
                    this.labelButton = this.lang.send;
                    this.loading = false;
                })
            )
            .subscribe((data: any) => {
                this.loadingForm = true;
                this.notificationService.success(this.lang.requestSentByEmail);
                location.href = 'index.php?display=true&page=login';
            }, (err: any) => {
                this.notificationService.handleErrors(err);
            });
    }

    cancel() {
        location.href = 'index.php?display=true&page=login';
    }
}
