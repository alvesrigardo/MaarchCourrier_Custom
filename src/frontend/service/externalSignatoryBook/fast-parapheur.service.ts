import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { catchError, of, tap } from 'rxjs';
import { NotificationService } from '@service/notification/notification.service';
import { TranslateService } from '@ngx-translate/core';

@Injectable({
    providedIn: 'root'
})

export class FastParapheurService {

    autocompleteUsersRoute: string = '/rest/autocomplete/fastParapheurUsers';

    constructor(
        private http: HttpClient,
        private notify: NotificationService,
        private translate: TranslateService
    ) { }

    getUserAvatar(externalId: number = null) {
        return new Promise((resolve) => {
            this.http.get('assets/fast.png', { responseType: 'blob' }).pipe(
                tap((response: any) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(response);
                    reader.onloadend = () => {
                        resolve(reader.result as any);
                    };
                }),
                catchError(err => {
                    this.notify.handleErrors(err);
                    return of(false);
                })
            ).subscribe();
        });
    }

    getOtpConfig() {
        return new Promise((resolve) => {
            this.http.get('../rest/maarchParapheurOtp').pipe(
                tap((data: any) => {
                    resolve(data.otp.length ?? null);
                }),
                catchError((err: any) => {
                    this.notify.handleSoftErrors(err);
                    resolve(null);
                    return of(false);
                })
            ).subscribe();
        });
    }

    loadListModel() {
        /**
         * Load list model from Fast Parapheur API
         */
    }

    loadWorkflow() {
        /**
         * Load worfklow from Fast Parapheur API
         */
    }

    getAutocompleteDatas() {
        /**
         * Get datas from autocomplete users url
         */
    }

    linkAccountToSignatoryBook(externalId: any, serialId: number) {
        return new Promise((resolve) => {
            this.http.put(`../rest/users/${serialId}/linkToFastParapheur`, { fastParapheurUserEmail: externalId.email }).pipe(
                tap(() => {
                    this.notify.success(this.translate.instant('lang.accountLinked'));
                    resolve(true);
                }),
                catchError((err: any) => {
                    this.notify.handleSoftErrors(err);
                    resolve(false);
                    return of(false);
                })
            ).subscribe();
        });
    }

    unlinkSignatoryBookAccount(serialId: number) {
        return new Promise((resolve) => {
            this.http.put(`../rest/users/${serialId}/unlinkToFastParapheur`, {}).pipe(
                tap(() => {
                    resolve(true);
                }),
                catchError((err: any) => {
                    this.notify.handleSoftErrors(err);
                    resolve(false);
                    return of(false);
                })
            ).subscribe();
        });
    }

    createExternalSignatoryBookAccount(id: number, login: string, serialId: number) {
        return new Promise((resolve) => {
            this.http.put(`../rest/users/${id}/createInMaarchParapheur`, { login: login }).pipe(
                tap((data: any) => {
                    this.notify.success(this.translate.instant('lang.accountAdded'));
                    resolve(data);
                }),
                catchError((err: any) => {
                    if (err.error.errors === 'Login already exists') {
                        this.translate.instant('lang.loginAlreadyExistsInMaarchParapheur');
                    } else {
                        this.notify.handleSoftErrors(err);
                    }
                    resolve(false);
                    return of(false);
                })
            ).subscribe();
        });
    }

    checkInfoExternalSignatoryBookAccount(serialId: number) {
        return new Promise((resolve) => {
            this.http.get('../rest/users/' + serialId + '/statusInFastParapheur').pipe(
                tap((data: any) => {
                    resolve(data);
                }),
                catchError((err: any) => {
                    this.notify.handleSoftErrors(err);
                    resolve(null);
                    return of(false);
                })
            ).subscribe();
        });
    }
}
