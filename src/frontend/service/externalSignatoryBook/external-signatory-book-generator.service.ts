import { Injectable, Injector } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { catchError, of, tap } from 'rxjs';
import { NotificationService } from '@service/notification/notification.service';
import { MaarchParapheurService } from './maarch-parapheur.service';
import { FastParapheurService } from './fast-parapheur.service';
import { TranslateService } from '@ngx-translate/core';
@Injectable()

export class ExternalSignatoryBookManagerService {

    allowedSignatoryBook: string[] = ['maarchParapheur', 'fastParapheur'];
    enabledSignatoryBook: string = 'maarchParapheur';
    serviceInjected: MaarchParapheurService | FastParapheurService;

    constructor(
        private injector: Injector,
        private http: HttpClient,
        private notifications: NotificationService,
        private translate: TranslateService
    ) {
        this.getEnabledSignatoryBook();
        if (this.allowedSignatoryBook.indexOf(this.enabledSignatoryBook) > -1) {
            if (this.enabledSignatoryBook === 'maarchParapheur') {
                this.serviceInjected = this.injector.get<MaarchParapheurService>(MaarchParapheurService);
            } else if (this.enabledSignatoryBook === 'fastParapheur') {
                this.serviceInjected = this.injector.get<FastParapheurService>(FastParapheurService);
            }
        } else {
            this.notifications.handleSoftErrors(this.translate.instant('lang.externalSignoryBookNotEnabled'));
        }
    }

    getEnabledSignatoryBook() {
        this.http.get('../rest/externalSignatureBooks/enabled').pipe(
            tap((data: any) => {
                this.enabledSignatoryBook = data.enabledSignatureBook;
            }),
            catchError((err: any) => {
                this.notifications.handleSoftErrors(err);
                return of(false);
            })
        ).subscribe();
    }

    checkExternalSignatureBook(data: any): Promise<any> {
        return new Promise((resolve) => {
            this.http.post(`../rest/resourcesList/users/${data.userId}/groups/${data.groupId}/baskets/${data.basketId}/checkExternalSignatoryBook`, { resources: data.resIds }).pipe(
                tap((result: any) => {
                    resolve(result);
                }),
                catchError((err: any) => {
                    this.notifications.handleSoftErrors(err);
                    resolve(null);
                    return of(false);
                })
            ).subscribe();

        });
    }

    loadListModel(entityId: number) {
        return this.serviceInjected.loadListModel(entityId);
    }

    loadWorkflow(attachmentId: number, type: string) {
        return this.serviceInjected.loadWorkflow(attachmentId, type);
    }

    getUserAvatar(externalId: number) {
        return this.serviceInjected.getUserAvatar(externalId);
    }

    getOtpConfig() {
        return this.serviceInjected.getOtpConfig();
    }

    getAutocompleteUsersRoute(): string {
        return this.serviceInjected.autocompleteUsersRoute;
    }

    isValidExtWorkflow(workflow: any[]): boolean {
        let res: boolean = true;
        workflow.forEach((item: any, indexUserRgs: number) => {
            if (['visa', 'stamp'].indexOf(item.role) === -1) {
                if (workflow.filter((itemUserStamp: any, indexUserStamp: number) => indexUserStamp > indexUserRgs && itemUserStamp.role === 'stamp').length > 0) {
                    res = false;
                }
            } else {
                return true;
            }
        });
        return res;
    }
}
