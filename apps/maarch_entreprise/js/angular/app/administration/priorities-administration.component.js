"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = require("@angular/core");
var http_1 = require("@angular/common/http");
var translate_component_1 = require("../translate.component");
var notification_service_1 = require("../notification.service");
var PrioritiesAdministrationComponent = /** @class */ (function () {
    function PrioritiesAdministrationComponent(http, notify) {
        this.http = http;
        this.notify = notify;
        this.lang = translate_component_1.LANG;
        this.loading = false;
        this.priorities = [];
    }
    PrioritiesAdministrationComponent.prototype.updateBreadcrumb = function (applicationName) {
        if ($j('#ariane')[0]) {
            $j('#ariane')[0].innerHTML = "<a href='index.php?reinit=true'>" + applicationName + "</a> > <a onclick='location.hash = \"/administration\"' style='cursor: pointer'>Administration</a> > Priorités";
        }
    };
    PrioritiesAdministrationComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.coreUrl = angularGlobals.coreUrl;
        this.updateBreadcrumb(angularGlobals.applicationName);
        this.loading = true;
        this.http.get(this.coreUrl + 'rest/priorities')
            .subscribe(function (data) {
            _this.priorities = data["priorities"];
            _this.loading = false;
        }, function () {
            location.href = "index.php";
        });
    };
    PrioritiesAdministrationComponent.prototype.deletePriority = function (id) {
        var _this = this;
        var r = confirm(this.lang.deleteMsg);
        if (r) {
            this.http.delete(this.coreUrl + "rest/priorities/" + id)
                .subscribe(function (data) {
                _this.priorities = data["priorities"];
                _this.notify.success(_this.lang.priorityDeleted);
            }, function (err) {
                _this.notify.error(err.error.errors);
            });
        }
    };
    PrioritiesAdministrationComponent = __decorate([
        core_1.Component({
            templateUrl: angularGlobals["priorities-administrationView"],
            providers: [notification_service_1.NotificationService]
        }),
        __metadata("design:paramtypes", [http_1.HttpClient, notification_service_1.NotificationService])
    ], PrioritiesAdministrationComponent);
    return PrioritiesAdministrationComponent;
}());
exports.PrioritiesAdministrationComponent = PrioritiesAdministrationComponent;
