(self.webpackChunkmaarchCourrier=self.webpackChunkmaarchCourrier||[]).push([[8255],{1005:(N,b,a)=>{a.d(b,{g:()=>D});var p=a(4986),E=a(7272),d=a(5698),t=a(4482),v=a(5403),I=a(5032),A=a(9718),x=a(5577),f=a(8421);function C(_,g){return g?l=>(0,E.z)(g.pipe((0,d.q)(1),function R(){return(0,t.e)((_,g)=>{_.subscribe((0,v.x)(g,I.Z))})}()),l.pipe(C(_))):(0,x.z)((l,r)=>(0,f.Xf)(_(l,r)).pipe((0,d.q)(1),(0,A.h)(l)))}var P=a(5963);function D(_,g=p.z){const l=(0,P.H)(_,g);return C(()=>l)}},9718:(N,b,a)=>{a.d(b,{h:()=>E});var p=a(4004);function E(d){return(0,p.U)(()=>d)}},3101:(N,b,a)=>{a.d(b,{E:()=>_});var p=a(4408);let d,E=1;const t={};function v(l){return l in t&&(delete t[l],!0)}const I={setImmediate(l){const r=E++;return t[r]=!0,d||(d=Promise.resolve()),d.then(()=>v(r)&&l()),r},clearImmediate(l){v(l)}},{setImmediate:A,clearImmediate:x}=I,f={setImmediate(...l){const{delegate:r}=f;return(r?.setImmediate||A)(...l)},clearImmediate(l){const{delegate:r}=f;return(r?.clearImmediate||x)(l)},delegate:void 0};var P=a(7565);const _=new class D extends P.v{flush(r){this._active=!0;const h=this._scheduled;this._scheduled=void 0;const{actions:c}=this;let y;r=r||c.shift();do{if(y=r.execute(r.state,r.delay))break}while((r=c[0])&&r.id===h&&c.shift());if(this._active=!1,y){for(;(r=c[0])&&r.id===h&&c.shift();)r.unsubscribe();throw y}}}(class C extends p.o{constructor(r,h){super(r,h),this.scheduler=r,this.work=h}requestAsyncId(r,h,c=0){return null!==c&&c>0?super.requestAsyncId(r,h,c):(r.actions.push(this),r._scheduled||(r._scheduled=f.setImmediate(r.flush.bind(r,void 0))))}recycleAsyncId(r,h,c=0){var y;if(null!=c?c>0:this.delay>0)return super.recycleAsyncId(r,h,c);const{actions:T}=r;null!=h&&(null===(y=T[T.length-1])||void 0===y?void 0:y.id)!==h&&(f.clearImmediate(h),r._scheduled===h&&(r._scheduled=void 0))}})},8255:(N,b,a)=>{a.r(b),a.d(b,{MAT_MENU_CONTENT:()=>W,MAT_MENU_DEFAULT_OPTIONS:()=>H,MAT_MENU_PANEL:()=>j,MAT_MENU_SCROLL_STRATEGY:()=>K,MatMenu:()=>ae,MatMenuContent:()=>ne,MatMenuItem:()=>U,MatMenuModule:()=>ce,MatMenuTrigger:()=>ue,_MatMenuBase:()=>w,_MatMenuContentBase:()=>V,_MatMenuTriggerBase:()=>Q,fadeInItems:()=>ee,matMenuAnimations:()=>B,transformMenu:()=>te});var p=a(528),E=a(5600),d=a(2571),t=a(5642),v=a(7579),I=a(727),R=a(6451),A=a(9646),x=a(3101),f=a(8675),C=a(3900),P=a(5698),D=a(2722),_=a(9300),g=a(1005),l=a(8365),r=a(4193),h=a(7703),c=a(9836),y=a(6721),T=a(5571),G=a(3827),Z=a(1010);const $=["mat-menu-item",""];function J(s,u){1&s&&(t.\u0275\u0275namespaceSVG(),t.\u0275\u0275elementStart(0,"svg",2),t.\u0275\u0275element(1,"polygon",3),t.\u0275\u0275elementEnd())}const Y=["*"];function q(s,u){if(1&s){const e=t.\u0275\u0275getCurrentView();t.\u0275\u0275elementStart(0,"div",0),t.\u0275\u0275listener("keydown",function(i){t.\u0275\u0275restoreView(e);const o=t.\u0275\u0275nextContext();return t.\u0275\u0275resetView(o._handleKeydown(i))})("click",function(){t.\u0275\u0275restoreView(e);const i=t.\u0275\u0275nextContext();return t.\u0275\u0275resetView(i.closed.emit("click"))})("@transformMenu.start",function(i){t.\u0275\u0275restoreView(e);const o=t.\u0275\u0275nextContext();return t.\u0275\u0275resetView(o._onAnimationStart(i))})("@transformMenu.done",function(i){t.\u0275\u0275restoreView(e);const o=t.\u0275\u0275nextContext();return t.\u0275\u0275resetView(o._onAnimationDone(i))}),t.\u0275\u0275elementStart(1,"div",1),t.\u0275\u0275projection(2),t.\u0275\u0275elementEnd()()}if(2&s){const e=t.\u0275\u0275nextContext();t.\u0275\u0275property("id",e.panelId)("ngClass",e._classList)("@transformMenu",e._panelAnimationState),t.\u0275\u0275attribute("aria-label",e.ariaLabel||null)("aria-labelledby",e.ariaLabelledby||null)("aria-describedby",e.ariaDescribedby||null)}}const B={transformMenu:(0,l.trigger)("transformMenu",[(0,l.state)("void",(0,l.style)({opacity:0,transform:"scale(0.8)"})),(0,l.transition)("void => enter",(0,l.animate)("120ms cubic-bezier(0, 0, 0.2, 1)",(0,l.style)({opacity:1,transform:"scale(1)"}))),(0,l.transition)("* => void",(0,l.animate)("100ms 25ms linear",(0,l.style)({opacity:0})))]),fadeInItems:(0,l.trigger)("fadeInItems",[(0,l.state)("showing",(0,l.style)({opacity:1})),(0,l.transition)("void => *",[(0,l.style)({opacity:0}),(0,l.animate)("400ms 100ms cubic-bezier(0.55, 0, 0.55, 0.2)")])])},ee=B.fadeInItems,te=B.transformMenu,W=new t.InjectionToken("MatMenuContent");let V=(()=>{class s{constructor(e,n,i,o,m,M,O){this._template=e,this._componentFactoryResolver=n,this._appRef=i,this._injector=o,this._viewContainerRef=m,this._document=M,this._changeDetectorRef=O,this._attached=new v.x}attach(e={}){this._portal||(this._portal=new r.TemplatePortal(this._template,this._viewContainerRef)),this.detach(),this._outlet||(this._outlet=new r.DomPortalOutlet(this._document.createElement("div"),this._componentFactoryResolver,this._appRef,this._injector));const n=this._template.elementRef.nativeElement;n.parentNode.insertBefore(this._outlet.outletElement,n),this._changeDetectorRef?.markForCheck(),this._portal.attach(this._outlet,e),this._attached.next()}detach(){this._portal.isAttached&&this._portal.detach()}ngOnDestroy(){this._outlet&&this._outlet.dispose()}}return s.\u0275fac=function(e){return new(e||s)(t.\u0275\u0275directiveInject(t.TemplateRef),t.\u0275\u0275directiveInject(t.ComponentFactoryResolver),t.\u0275\u0275directiveInject(t.ApplicationRef),t.\u0275\u0275directiveInject(t.Injector),t.\u0275\u0275directiveInject(t.ViewContainerRef),t.\u0275\u0275directiveInject(h.DOCUMENT),t.\u0275\u0275directiveInject(t.ChangeDetectorRef))},s.\u0275dir=t.\u0275\u0275defineDirective({type:s}),s})(),ne=(()=>{class s extends V{}return s.\u0275fac=function(){let u;return function(n){return(u||(u=t.\u0275\u0275getInheritedFactory(s)))(n||s)}}(),s.\u0275dir=t.\u0275\u0275defineDirective({type:s,selectors:[["ng-template","matMenuContent",""]],features:[t.\u0275\u0275ProvidersFeature([{provide:W,useExisting:s}]),t.\u0275\u0275InheritDefinitionFeature]}),s})();const j=new t.InjectionToken("MAT_MENU_PANEL"),ie=(0,c.mixinDisableRipple)((0,c.mixinDisabled)(class{}));let U=(()=>{class s extends ie{constructor(e,n,i,o,m){super(),this._elementRef=e,this._document=n,this._focusMonitor=i,this._parentMenu=o,this._changeDetectorRef=m,this.role="menuitem",this._hovered=new v.x,this._focused=new v.x,this._highlighted=!1,this._triggersSubmenu=!1,o?.addItem?.(this)}focus(e,n){this._focusMonitor&&e?this._focusMonitor.focusVia(this._getHostElement(),e,n):this._getHostElement().focus(n),this._focused.next(this)}ngAfterViewInit(){this._focusMonitor&&this._focusMonitor.monitor(this._elementRef,!1)}ngOnDestroy(){this._focusMonitor&&this._focusMonitor.stopMonitoring(this._elementRef),this._parentMenu&&this._parentMenu.removeItem&&this._parentMenu.removeItem(this),this._hovered.complete(),this._focused.complete()}_getTabIndex(){return this.disabled?"-1":"0"}_getHostElement(){return this._elementRef.nativeElement}_checkDisabled(e){this.disabled&&(e.preventDefault(),e.stopPropagation())}_handleMouseEnter(){this._hovered.next(this)}getLabel(){const e=this._elementRef.nativeElement.cloneNode(!0),n=e.querySelectorAll("mat-icon, .material-icons");for(let i=0;i<n.length;i++)n[i].remove();return e.textContent?.trim()||""}_setHighlighted(e){this._highlighted=e,this._changeDetectorRef?.markForCheck()}_hasFocus(){return this._document&&this._document.activeElement===this._getHostElement()}}return s.\u0275fac=function(e){return new(e||s)(t.\u0275\u0275directiveInject(t.ElementRef),t.\u0275\u0275directiveInject(h.DOCUMENT),t.\u0275\u0275directiveInject(p.FocusMonitor),t.\u0275\u0275directiveInject(j,8),t.\u0275\u0275directiveInject(t.ChangeDetectorRef))},s.\u0275cmp=t.\u0275\u0275defineComponent({type:s,selectors:[["","mat-menu-item",""]],hostAttrs:[1,"mat-focus-indicator"],hostVars:10,hostBindings:function(e,n){1&e&&t.\u0275\u0275listener("click",function(o){return n._checkDisabled(o)})("mouseenter",function(){return n._handleMouseEnter()}),2&e&&(t.\u0275\u0275attribute("role",n.role)("tabindex",n._getTabIndex())("aria-disabled",n.disabled.toString())("disabled",n.disabled||null),t.\u0275\u0275classProp("mat-menu-item",!0)("mat-menu-item-highlighted",n._highlighted)("mat-menu-item-submenu-trigger",n._triggersSubmenu))},inputs:{disabled:"disabled",disableRipple:"disableRipple",role:"role"},exportAs:["matMenuItem"],features:[t.\u0275\u0275InheritDefinitionFeature],attrs:$,ngContentSelectors:Y,decls:3,vars:3,consts:[["matRipple","",1,"mat-menu-ripple",3,"matRippleDisabled","matRippleTrigger"],["class","mat-menu-submenu-icon","viewBox","0 0 5 10","focusable","false",4,"ngIf"],["viewBox","0 0 5 10","focusable","false",1,"mat-menu-submenu-icon"],["points","0,0 5,5 0,10"]],template:function(e,n){1&e&&(t.\u0275\u0275projectionDef(),t.\u0275\u0275projection(0),t.\u0275\u0275element(1,"div",0),t.\u0275\u0275template(2,J,2,0,"svg",1)),2&e&&(t.\u0275\u0275advance(1),t.\u0275\u0275property("matRippleDisabled",n.disableRipple||n.disabled)("matRippleTrigger",n._getHostElement()),t.\u0275\u0275advance(1),t.\u0275\u0275property("ngIf",n._triggersSubmenu))},dependencies:[h.NgIf,c.MatRipple],encapsulation:2,changeDetection:0}),s})();const H=new t.InjectionToken("mat-menu-default-options",{providedIn:"root",factory:function se(){return{overlapTrigger:!1,xPosition:"after",yPosition:"below",backdropClass:"cdk-overlay-transparent-backdrop"}}});let oe=0,w=(()=>{class s{constructor(e,n,i,o){this._elementRef=e,this._ngZone=n,this._defaultOptions=i,this._changeDetectorRef=o,this._xPosition=this._defaultOptions.xPosition,this._yPosition=this._defaultOptions.yPosition,this._directDescendantItems=new t.QueryList,this._tabSubscription=I.w0.EMPTY,this._classList={},this._panelAnimationState="void",this._animationDone=new v.x,this.overlayPanelClass=this._defaultOptions.overlayPanelClass||"",this.backdropClass=this._defaultOptions.backdropClass,this._overlapTrigger=this._defaultOptions.overlapTrigger,this._hasBackdrop=this._defaultOptions.hasBackdrop,this.closed=new t.EventEmitter,this.close=this.closed,this.panelId="mat-menu-panel-"+oe++}get xPosition(){return this._xPosition}set xPosition(e){this._xPosition=e,this.setPositionClasses()}get yPosition(){return this._yPosition}set yPosition(e){this._yPosition=e,this.setPositionClasses()}get overlapTrigger(){return this._overlapTrigger}set overlapTrigger(e){this._overlapTrigger=(0,E.coerceBooleanProperty)(e)}get hasBackdrop(){return this._hasBackdrop}set hasBackdrop(e){this._hasBackdrop=(0,E.coerceBooleanProperty)(e)}set panelClass(e){const n=this._previousPanelClass;n&&n.length&&n.split(" ").forEach(i=>{this._classList[i]=!1}),this._previousPanelClass=e,e&&e.length&&(e.split(" ").forEach(i=>{this._classList[i]=!0}),this._elementRef.nativeElement.className="")}get classList(){return this.panelClass}set classList(e){this.panelClass=e}ngOnInit(){this.setPositionClasses()}ngAfterContentInit(){this._updateDirectDescendants(),this._keyManager=new p.FocusKeyManager(this._directDescendantItems).withWrap().withTypeAhead().withHomeAndEnd(),this._tabSubscription=this._keyManager.tabOut.subscribe(()=>this.closed.emit("tab")),this._directDescendantItems.changes.pipe((0,f.O)(this._directDescendantItems),(0,C.w)(e=>(0,R.T)(...e.map(n=>n._focused)))).subscribe(e=>this._keyManager.updateActiveItem(e)),this._directDescendantItems.changes.subscribe(e=>{const n=this._keyManager;if("enter"===this._panelAnimationState&&n.activeItem?._hasFocus()){const i=e.toArray(),o=Math.max(0,Math.min(i.length-1,n.activeItemIndex||0));i[o]&&!i[o].disabled?n.setActiveItem(o):n.setNextItemActive()}})}ngOnDestroy(){this._directDescendantItems.destroy(),this._tabSubscription.unsubscribe(),this.closed.complete()}_hovered(){return this._directDescendantItems.changes.pipe((0,f.O)(this._directDescendantItems),(0,C.w)(n=>(0,R.T)(...n.map(i=>i._hovered))))}addItem(e){}removeItem(e){}_handleKeydown(e){const n=e.keyCode,i=this._keyManager;switch(n){case d.ESCAPE:(0,d.hasModifierKey)(e)||(e.preventDefault(),this.closed.emit("keydown"));break;case d.LEFT_ARROW:this.parentMenu&&"ltr"===this.direction&&this.closed.emit("keydown");break;case d.RIGHT_ARROW:this.parentMenu&&"rtl"===this.direction&&this.closed.emit("keydown");break;default:return(n===d.UP_ARROW||n===d.DOWN_ARROW)&&i.setFocusOrigin("keyboard"),void i.onKeydown(e)}e.stopPropagation()}focusFirstItem(e="program"){this._ngZone.onStable.pipe((0,P.q)(1)).subscribe(()=>{let n=null;if(this._directDescendantItems.length&&(n=this._directDescendantItems.first._getHostElement().closest('[role="menu"]')),!n||!n.contains(document.activeElement)){const i=this._keyManager;i.setFocusOrigin(e).setFirstItemActive(),!i.activeItem&&n&&n.focus()}})}resetActiveItem(){this._keyManager.setActiveItem(-1)}setElevation(e){const n=Math.min(this._baseElevation+e,24),i=`${this._elevationPrefix}${n}`,o=Object.keys(this._classList).find(m=>m.startsWith(this._elevationPrefix));(!o||o===this._previousElevation)&&(this._previousElevation&&(this._classList[this._previousElevation]=!1),this._classList[i]=!0,this._previousElevation=i)}setPositionClasses(e=this.xPosition,n=this.yPosition){const i=this._classList;i["mat-menu-before"]="before"===e,i["mat-menu-after"]="after"===e,i["mat-menu-above"]="above"===n,i["mat-menu-below"]="below"===n,this._changeDetectorRef?.markForCheck()}_startAnimation(){this._panelAnimationState="enter"}_resetAnimation(){this._panelAnimationState="void"}_onAnimationDone(e){this._animationDone.next(e),this._isAnimating=!1}_onAnimationStart(e){this._isAnimating=!0,"enter"===e.toState&&0===this._keyManager.activeItemIndex&&(e.element.scrollTop=0)}_updateDirectDescendants(){this._allItems.changes.pipe((0,f.O)(this._allItems)).subscribe(e=>{this._directDescendantItems.reset(e.filter(n=>n._parentMenu===this)),this._directDescendantItems.notifyOnChanges()})}}return s.\u0275fac=function(e){return new(e||s)(t.\u0275\u0275directiveInject(t.ElementRef),t.\u0275\u0275directiveInject(t.NgZone),t.\u0275\u0275directiveInject(H),t.\u0275\u0275directiveInject(t.ChangeDetectorRef))},s.\u0275dir=t.\u0275\u0275defineDirective({type:s,contentQueries:function(e,n,i){if(1&e&&(t.\u0275\u0275contentQuery(i,W,5),t.\u0275\u0275contentQuery(i,U,5),t.\u0275\u0275contentQuery(i,U,4)),2&e){let o;t.\u0275\u0275queryRefresh(o=t.\u0275\u0275loadQuery())&&(n.lazyContent=o.first),t.\u0275\u0275queryRefresh(o=t.\u0275\u0275loadQuery())&&(n._allItems=o),t.\u0275\u0275queryRefresh(o=t.\u0275\u0275loadQuery())&&(n.items=o)}},viewQuery:function(e,n){if(1&e&&t.\u0275\u0275viewQuery(t.TemplateRef,5),2&e){let i;t.\u0275\u0275queryRefresh(i=t.\u0275\u0275loadQuery())&&(n.templateRef=i.first)}},inputs:{backdropClass:"backdropClass",ariaLabel:["aria-label","ariaLabel"],ariaLabelledby:["aria-labelledby","ariaLabelledby"],ariaDescribedby:["aria-describedby","ariaDescribedby"],xPosition:"xPosition",yPosition:"yPosition",overlapTrigger:"overlapTrigger",hasBackdrop:"hasBackdrop",panelClass:["class","panelClass"],classList:"classList"},outputs:{closed:"closed",close:"close"}}),s})(),ae=(()=>{class s extends w{constructor(e,n,i,o){super(e,n,i,o),this._elevationPrefix="mat-elevation-z",this._baseElevation=4}}return s.\u0275fac=function(e){return new(e||s)(t.\u0275\u0275directiveInject(t.ElementRef),t.\u0275\u0275directiveInject(t.NgZone),t.\u0275\u0275directiveInject(H),t.\u0275\u0275directiveInject(t.ChangeDetectorRef))},s.\u0275cmp=t.\u0275\u0275defineComponent({type:s,selectors:[["mat-menu"]],hostVars:3,hostBindings:function(e,n){2&e&&t.\u0275\u0275attribute("aria-label",null)("aria-labelledby",null)("aria-describedby",null)},exportAs:["matMenu"],features:[t.\u0275\u0275ProvidersFeature([{provide:j,useExisting:s}]),t.\u0275\u0275InheritDefinitionFeature],ngContentSelectors:Y,decls:1,vars:0,consts:[["tabindex","-1","role","menu",1,"mat-menu-panel",3,"id","ngClass","keydown","click"],[1,"mat-menu-content"]],template:function(e,n){1&e&&(t.\u0275\u0275projectionDef(),t.\u0275\u0275template(0,q,3,6,"ng-template"))},dependencies:[h.NgClass],styles:['mat-menu{display:none}.mat-menu-panel{min-width:112px;max-width:280px;overflow:auto;-webkit-overflow-scrolling:touch;max-height:calc(100vh - 48px);border-radius:4px;outline:0;min-height:64px;position:relative}.mat-menu-panel.ng-animating{pointer-events:none}.cdk-high-contrast-active .mat-menu-panel{outline:solid 1px}.mat-menu-content:not(:empty){padding-top:8px;padding-bottom:8px}.mat-menu-item{-webkit-user-select:none;user-select:none;cursor:pointer;outline:none;border:none;-webkit-tap-highlight-color:rgba(0,0,0,0);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block;line-height:48px;height:48px;padding:0 16px;text-align:left;text-decoration:none;max-width:100%;position:relative}.mat-menu-item::-moz-focus-inner{border:0}.mat-menu-item[disabled]{cursor:default}[dir=rtl] .mat-menu-item{text-align:right}.mat-menu-item .mat-icon{margin-right:16px;vertical-align:middle}.mat-menu-item .mat-icon svg{vertical-align:top}[dir=rtl] .mat-menu-item .mat-icon{margin-left:16px;margin-right:0}.mat-menu-item[disabled]::after{display:block;position:absolute;content:"";top:0;left:0;bottom:0;right:0}.cdk-high-contrast-active .mat-menu-item{margin-top:1px}.mat-menu-item-submenu-trigger{padding-right:32px}[dir=rtl] .mat-menu-item-submenu-trigger{padding-right:16px;padding-left:32px}.mat-menu-submenu-icon{position:absolute;top:50%;right:16px;transform:translateY(-50%);width:5px;height:10px;fill:currentColor}[dir=rtl] .mat-menu-submenu-icon{right:auto;left:16px;transform:translateY(-50%) scaleX(-1)}.cdk-high-contrast-active .mat-menu-submenu-icon{fill:CanvasText}button.mat-menu-item{width:100%}.mat-menu-item .mat-menu-ripple{top:0;left:0;right:0;bottom:0;position:absolute;pointer-events:none}'],encapsulation:2,data:{animation:[B.transformMenu,B.fadeInItems]},changeDetection:0}),s})();const K=new t.InjectionToken("mat-menu-scroll-strategy"),le={provide:K,deps:[T.Overlay],useFactory:function re(s){return()=>s.scrollStrategies.reposition()}},z=(0,G.normalizePassiveListenerOptions)({passive:!0});let Q=(()=>{class s{constructor(e,n,i,o,m,M,O,k,S){this._overlay=e,this._element=n,this._viewContainerRef=i,this._menuItemInstance=M,this._dir=O,this._focusMonitor=k,this._ngZone=S,this._overlayRef=null,this._menuOpen=!1,this._closingActionsSubscription=I.w0.EMPTY,this._hoverSubscription=I.w0.EMPTY,this._menuCloseSubscription=I.w0.EMPTY,this._handleTouchStart=L=>{(0,p.isFakeTouchstartFromScreenReader)(L)||(this._openedBy="touch")},this._openedBy=void 0,this.restoreFocus=!0,this.menuOpened=new t.EventEmitter,this.onMenuOpen=this.menuOpened,this.menuClosed=new t.EventEmitter,this.onMenuClose=this.menuClosed,this._scrollStrategy=o,this._parentMaterialMenu=m instanceof w?m:void 0,n.nativeElement.addEventListener("touchstart",this._handleTouchStart,z),M&&(M._triggersSubmenu=this.triggersSubmenu())}get _deprecatedMatMenuTriggerFor(){return this.menu}set _deprecatedMatMenuTriggerFor(e){this.menu=e}get menu(){return this._menu}set menu(e){e!==this._menu&&(this._menu=e,this._menuCloseSubscription.unsubscribe(),e&&(this._menuCloseSubscription=e.close.subscribe(n=>{this._destroyMenu(n),("click"===n||"tab"===n)&&this._parentMaterialMenu&&this._parentMaterialMenu.closed.emit(n)})))}ngAfterContentInit(){this._handleHover()}ngOnDestroy(){this._overlayRef&&(this._overlayRef.dispose(),this._overlayRef=null),this._element.nativeElement.removeEventListener("touchstart",this._handleTouchStart,z),this._menuCloseSubscription.unsubscribe(),this._closingActionsSubscription.unsubscribe(),this._hoverSubscription.unsubscribe()}get menuOpen(){return this._menuOpen}get dir(){return this._dir&&"rtl"===this._dir.value?"rtl":"ltr"}triggersSubmenu(){return!(!this._menuItemInstance||!this._parentMaterialMenu)}toggleMenu(){return this._menuOpen?this.closeMenu():this.openMenu()}openMenu(){const e=this.menu;if(this._menuOpen||!e)return;const n=this._createOverlay(e),i=n.getConfig(),o=i.positionStrategy;this._setPosition(e,o),i.hasBackdrop=e.hasBackdrop??!this.triggersSubmenu(),n.attach(this._getPortal(e)),e.lazyContent&&e.lazyContent.attach(this.menuData),this._closingActionsSubscription=this._menuClosingActions().subscribe(()=>this.closeMenu()),this._initMenu(e),e instanceof w&&(e._startAnimation(),e._directDescendantItems.changes.pipe((0,D.R)(e.close)).subscribe(()=>{o.withLockedPosition(!1).reapplyLastPosition(),o.withLockedPosition(!0)}))}closeMenu(){this.menu?.close.emit()}focus(e,n){this._focusMonitor&&e?this._focusMonitor.focusVia(this._element,e,n):this._element.nativeElement.focus(n)}updatePosition(){this._overlayRef?.updatePosition()}_destroyMenu(e){if(!this._overlayRef||!this.menuOpen)return;const n=this.menu;this._closingActionsSubscription.unsubscribe(),this._overlayRef.detach(),this.restoreFocus&&("keydown"===e||!this._openedBy||!this.triggersSubmenu())&&this.focus(this._openedBy),this._openedBy=void 0,n instanceof w?(n._resetAnimation(),n.lazyContent?n._animationDone.pipe((0,_.h)(i=>"void"===i.toState),(0,P.q)(1),(0,D.R)(n.lazyContent._attached)).subscribe({next:()=>n.lazyContent.detach(),complete:()=>this._setIsMenuOpen(!1)}):this._setIsMenuOpen(!1)):(this._setIsMenuOpen(!1),n?.lazyContent?.detach())}_initMenu(e){e.parentMenu=this.triggersSubmenu()?this._parentMaterialMenu:void 0,e.direction=this.dir,this._setMenuElevation(e),e.focusFirstItem(this._openedBy||"program"),this._setIsMenuOpen(!0)}_setMenuElevation(e){if(e.setElevation){let n=0,i=e.parentMenu;for(;i;)n++,i=i.parentMenu;e.setElevation(n)}}_setIsMenuOpen(e){this._menuOpen=e,this._menuOpen?this.menuOpened.emit():this.menuClosed.emit(),this.triggersSubmenu()&&this._menuItemInstance._setHighlighted(e)}_createOverlay(e){if(!this._overlayRef){const n=this._getOverlayConfig(e);this._subscribeToPositions(e,n.positionStrategy),this._overlayRef=this._overlay.create(n),this._overlayRef.keydownEvents().subscribe()}return this._overlayRef}_getOverlayConfig(e){return new T.OverlayConfig({positionStrategy:this._overlay.position().flexibleConnectedTo(this._element).withLockedPosition().withGrowAfterOpen().withTransformOriginOn(".mat-menu-panel, .mat-mdc-menu-panel"),backdropClass:e.backdropClass||"cdk-overlay-transparent-backdrop",panelClass:e.overlayPanelClass,scrollStrategy:this._scrollStrategy(),direction:this._dir})}_subscribeToPositions(e,n){e.setPositionClasses&&n.positionChanges.subscribe(i=>{const o="start"===i.connectionPair.overlayX?"after":"before",m="top"===i.connectionPair.overlayY?"below":"above";this._ngZone?this._ngZone.run(()=>e.setPositionClasses(o,m)):e.setPositionClasses(o,m)})}_setPosition(e,n){let[i,o]="before"===e.xPosition?["end","start"]:["start","end"],[m,M]="above"===e.yPosition?["bottom","top"]:["top","bottom"],[O,k]=[m,M],[S,L]=[i,o],F=0;if(this.triggersSubmenu()){if(L=i="before"===e.xPosition?"start":"end",o=S="end"===i?"start":"end",this._parentMaterialMenu){if(null==this._parentInnerPadding){const X=this._parentMaterialMenu.items.first;this._parentInnerPadding=X?X._getHostElement().offsetTop:0}F="bottom"===m?this._parentInnerPadding:-this._parentInnerPadding}}else e.overlapTrigger||(O="top"===m?"bottom":"top",k="top"===M?"bottom":"top");n.withPositions([{originX:i,originY:O,overlayX:S,overlayY:m,offsetY:F},{originX:o,originY:O,overlayX:L,overlayY:m,offsetY:F},{originX:i,originY:k,overlayX:S,overlayY:M,offsetY:-F},{originX:o,originY:k,overlayX:L,overlayY:M,offsetY:-F}])}_menuClosingActions(){const e=this._overlayRef.backdropClick(),n=this._overlayRef.detachments(),i=this._parentMaterialMenu?this._parentMaterialMenu.closed:(0,A.of)(),o=this._parentMaterialMenu?this._parentMaterialMenu._hovered().pipe((0,_.h)(m=>m!==this._menuItemInstance),(0,_.h)(()=>this._menuOpen)):(0,A.of)();return(0,R.T)(e,i,o,n)}_handleMousedown(e){(0,p.isFakeMousedownFromScreenReader)(e)||(this._openedBy=0===e.button?"mouse":void 0,this.triggersSubmenu()&&e.preventDefault())}_handleKeydown(e){const n=e.keyCode;(n===d.ENTER||n===d.SPACE)&&(this._openedBy="keyboard"),this.triggersSubmenu()&&(n===d.RIGHT_ARROW&&"ltr"===this.dir||n===d.LEFT_ARROW&&"rtl"===this.dir)&&(this._openedBy="keyboard",this.openMenu())}_handleClick(e){this.triggersSubmenu()?(e.stopPropagation(),this.openMenu()):this.toggleMenu()}_handleHover(){!this.triggersSubmenu()||!this._parentMaterialMenu||(this._hoverSubscription=this._parentMaterialMenu._hovered().pipe((0,_.h)(e=>e===this._menuItemInstance&&!e.disabled),(0,g.g)(0,x.E)).subscribe(()=>{this._openedBy="mouse",this.menu instanceof w&&this.menu._isAnimating?this.menu._animationDone.pipe((0,P.q)(1),(0,g.g)(0,x.E),(0,D.R)(this._parentMaterialMenu._hovered())).subscribe(()=>this.openMenu()):this.openMenu()}))}_getPortal(e){return(!this._portal||this._portal.templateRef!==e.templateRef)&&(this._portal=new r.TemplatePortal(e.templateRef,this._viewContainerRef)),this._portal}}return s.\u0275fac=function(e){return new(e||s)(t.\u0275\u0275directiveInject(T.Overlay),t.\u0275\u0275directiveInject(t.ElementRef),t.\u0275\u0275directiveInject(t.ViewContainerRef),t.\u0275\u0275directiveInject(K),t.\u0275\u0275directiveInject(j,8),t.\u0275\u0275directiveInject(U,10),t.\u0275\u0275directiveInject(y.Directionality,8),t.\u0275\u0275directiveInject(p.FocusMonitor),t.\u0275\u0275directiveInject(t.NgZone))},s.\u0275dir=t.\u0275\u0275defineDirective({type:s,hostVars:3,hostBindings:function(e,n){1&e&&t.\u0275\u0275listener("click",function(o){return n._handleClick(o)})("mousedown",function(o){return n._handleMousedown(o)})("keydown",function(o){return n._handleKeydown(o)}),2&e&&t.\u0275\u0275attribute("aria-haspopup",n.menu?"menu":null)("aria-expanded",n.menuOpen||null)("aria-controls",n.menuOpen?n.menu.panelId:null)},inputs:{_deprecatedMatMenuTriggerFor:["mat-menu-trigger-for","_deprecatedMatMenuTriggerFor"],menu:["matMenuTriggerFor","menu"],menuData:["matMenuTriggerData","menuData"],restoreFocus:["matMenuTriggerRestoreFocus","restoreFocus"]},outputs:{menuOpened:"menuOpened",onMenuOpen:"onMenuOpen",menuClosed:"menuClosed",onMenuClose:"onMenuClose"}}),s})(),ue=(()=>{class s extends Q{}return s.\u0275fac=function(){let u;return function(n){return(u||(u=t.\u0275\u0275getInheritedFactory(s)))(n||s)}}(),s.\u0275dir=t.\u0275\u0275defineDirective({type:s,selectors:[["","mat-menu-trigger-for",""],["","matMenuTriggerFor",""]],hostAttrs:[1,"mat-menu-trigger"],exportAs:["matMenuTrigger"],features:[t.\u0275\u0275InheritDefinitionFeature]}),s})(),ce=(()=>{class s{}return s.\u0275fac=function(e){return new(e||s)},s.\u0275mod=t.\u0275\u0275defineNgModule({type:s}),s.\u0275inj=t.\u0275\u0275defineInjector({providers:[le],imports:[h.CommonModule,c.MatCommonModule,c.MatRippleModule,T.OverlayModule,Z.CdkScrollableModule,c.MatCommonModule]}),s})()}}]);