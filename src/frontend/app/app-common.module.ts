import { CommonModule }                         from '@angular/common';

import { NgModule }                             from '@angular/core';

/*CORE IMPORTS*/
import { BrowserModule, HammerGestureConfig, HAMMER_GESTURE_CONFIG }   from '@angular/platform-browser';
import { BrowserAnimationsModule }              from '@angular/platform-browser/animations';
import { FormsModule, ReactiveFormsModule }     from '@angular/forms';
import { HttpClientModule }                     from '@angular/common/http';
import { RouterModule }                         from '@angular/router';
import { DragDropModule }                         from '@angular/cdk/drag-drop';

/*PLUGINS IMPORTS*/
import { SortPipe }                             from '../plugins/sorting.pipe';
import { PdfViewerModule }                      from 'ng2-pdf-viewer';
//import { SimplePdfViewerModule }                from 'simple-pdf-viewer';
import { NgStringPipesModule }                  from 'ngx-pipes';
import { LatinisePipe }                         from 'ngx-pipes';
import { CookieService }                        from 'ngx-cookie-service';
import { TimeAgoPipe }                          from '../plugins/timeAgo.pipe';
import { TimeLimitPipe }                        from '../plugins/timeLimit.pipe';
import { FilterListPipe }                       from '../plugins/filterList.pipe';

/*FRONT IMPORTS*/
import { AppMaterialModule }                    from './app-material.module';

import { SmdFabSpeedDialComponent,SmdFabSpeedDialTrigger, SmdFabSpeedDialActions, }             from '../plugins/fab-speed-dial';


/*MENU COMPONENT*/
import { HeaderRightComponent }                 from './header/header-right.component';
import { HeaderLeftComponent }                  from './header/header-left.component';
import { HeaderPanelComponent }                  from './header/header-panel.component';
import { MainHeaderComponent }                  from './menu/main-header.component';
import { MenuComponent }                        from './menu/menu.component';
import { MenuNavComponent }                     from './menu/menu-nav.component';
import { MenuShortcutComponent, IndexingGroupModalComponent }                from './menu/menu-shortcut.component';

/*SEARCH*/
import { SearchHomeComponent }                        from './search/search-home.component';

/*SEARCH*/
import { BasketHomeComponent }                        from './basket/basket-home.component';


/*MODAL*/
import { AlertComponent }                        from '../plugins/modal/alert.component';


export class MyHammerConfig extends HammerGestureConfig {
    overrides = <any> {
        'pinch': { enable: false },
        'rotate': { enable: false }
    }
}
@NgModule({
    imports: [
        CommonModule,
        BrowserModule,
        BrowserAnimationsModule,
        FormsModule,
        HttpClientModule,
        RouterModule,
        PdfViewerModule,
        NgStringPipesModule,
        AppMaterialModule,
        DragDropModule
    ],
    declarations: [
        MainHeaderComponent,
        MenuComponent,
        MenuNavComponent,
        MenuShortcutComponent,
        HeaderRightComponent,
        HeaderLeftComponent,
        HeaderPanelComponent,
        SearchHomeComponent,
        BasketHomeComponent,
        SortPipe,
        TimeAgoPipe,
        TimeLimitPipe,
        FilterListPipe,
        IndexingGroupModalComponent,
        SmdFabSpeedDialComponent,
        SmdFabSpeedDialTrigger,
        SmdFabSpeedDialActions,
        AlertComponent
    ],
    exports: [
        CommonModule,
        MainHeaderComponent,
        MenuComponent,
        MenuNavComponent,
        MenuShortcutComponent,
        HeaderRightComponent,
        HeaderLeftComponent,
        HeaderPanelComponent,
        SearchHomeComponent,
        BasketHomeComponent,
        BrowserModule,
        BrowserAnimationsModule,
        FormsModule,
        ReactiveFormsModule,
        HttpClientModule,
        RouterModule,
        AppMaterialModule,
        SortPipe,
        TimeAgoPipe,
        TimeLimitPipe,
        FilterListPipe,
        PdfViewerModule,
        NgStringPipesModule,
        SmdFabSpeedDialComponent,
        SmdFabSpeedDialTrigger,
        SmdFabSpeedDialActions,
        DragDropModule
    ],
    providers: [
        LatinisePipe,
        CookieService,
        {
            provide: HAMMER_GESTURE_CONFIG,
            useClass: MyHammerConfig
        }
    ],
    entryComponents: [
        IndexingGroupModalComponent,
        AlertComponent
    ],
})
export class SharedModule { }
