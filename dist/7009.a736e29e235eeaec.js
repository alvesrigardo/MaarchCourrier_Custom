(self.webpackChunkmaarchCourrier=self.webpackChunkmaarchCourrier||[]).push([[7009],{7009:(N,M,l)=>{l.r(M),l.d(M,{MAT_SNACK_BAR_DATA:()=>B,MAT_SNACK_BAR_DEFAULT_OPTIONS:()=>k,MAT_SNACK_BAR_DEFAULT_OPTIONS_FACTORY:()=>P,MatSnackBar:()=>F,MatSnackBarConfig:()=>u,MatSnackBarContainer:()=>R,MatSnackBarModule:()=>O,MatSnackBarRef:()=>p,SimpleSnackBar:()=>E,_MatSnackBarBase:()=>T,_MatSnackBarContainerBase:()=>D,matSnackBarAnimations:()=>g});var f=l(5571),_=l(4193),A=l(7703),e=l(5642),S=l(9836),C=l(4698),m=l(7579),x=l(3827),b=l(5698),I=l(2722),d=l(8365),y=l(528),v=l(7338);function j(a,o){if(1&a){const t=e.\u0275\u0275getCurrentView();e.\u0275\u0275elementStart(0,"div",2)(1,"button",3),e.\u0275\u0275listener("click",function(){e.\u0275\u0275restoreView(t);const i=e.\u0275\u0275nextContext();return e.\u0275\u0275resetView(i.action())}),e.\u0275\u0275text(2),e.\u0275\u0275elementEnd()()}if(2&a){const t=e.\u0275\u0275nextContext();e.\u0275\u0275advance(2),e.\u0275\u0275textInterpolate(t.data.action)}}function w(a,o){}const B=new e.InjectionToken("MatSnackBarData");class u{constructor(){this.politeness="assertive",this.announcementMessage="",this.duration=0,this.data=null,this.horizontalPosition="center",this.verticalPosition="bottom"}}const L=Math.pow(2,31)-1;class p{constructor(o,t){this._overlayRef=t,this._afterDismissed=new m.x,this._afterOpened=new m.x,this._onAction=new m.x,this._dismissedByAction=!1,this.containerInstance=o,o._onExit.subscribe(()=>this._finishDismiss())}dismiss(){this._afterDismissed.closed||this.containerInstance.exit(),clearTimeout(this._durationTimeoutId)}dismissWithAction(){this._onAction.closed||(this._dismissedByAction=!0,this._onAction.next(),this._onAction.complete(),this.dismiss()),clearTimeout(this._durationTimeoutId)}closeWithAction(){this.dismissWithAction()}_dismissAfter(o){this._durationTimeoutId=setTimeout(()=>this.dismiss(),Math.min(o,L))}_open(){this._afterOpened.closed||(this._afterOpened.next(),this._afterOpened.complete())}_finishDismiss(){this._overlayRef.dispose(),this._onAction.closed||this._onAction.complete(),this._afterDismissed.next({dismissedByAction:this._dismissedByAction}),this._afterDismissed.complete(),this._dismissedByAction=!1}afterDismissed(){return this._afterDismissed}afterOpened(){return this.containerInstance._onEnter}onAction(){return this._onAction}}let E=(()=>{class a{constructor(t,n){this.snackBarRef=t,this.data=n}action(){this.snackBarRef.dismissWithAction()}get hasAction(){return!!this.data.action}}return a.\u0275fac=function(t){return new(t||a)(e.\u0275\u0275directiveInject(p),e.\u0275\u0275directiveInject(B))},a.\u0275cmp=e.\u0275\u0275defineComponent({type:a,selectors:[["simple-snack-bar"]],hostAttrs:[1,"mat-simple-snackbar"],decls:3,vars:2,consts:[[1,"mat-simple-snack-bar-content"],["class","mat-simple-snackbar-action",4,"ngIf"],[1,"mat-simple-snackbar-action"],["mat-button","",3,"click"]],template:function(t,n){1&t&&(e.\u0275\u0275elementStart(0,"span",0),e.\u0275\u0275text(1),e.\u0275\u0275elementEnd(),e.\u0275\u0275template(2,j,3,1,"div",1)),2&t&&(e.\u0275\u0275advance(1),e.\u0275\u0275textInterpolate(n.data.message),e.\u0275\u0275advance(1),e.\u0275\u0275property("ngIf",n.hasAction))},dependencies:[A.NgIf,C.MatButton],styles:[".mat-simple-snackbar{display:flex;justify-content:space-between;align-items:center;line-height:20px;opacity:1}.mat-simple-snackbar-action{flex-shrink:0;margin:-8px -8px -8px 8px}.mat-simple-snackbar-action button{max-height:36px;min-width:0}[dir=rtl] .mat-simple-snackbar-action{margin-left:-8px;margin-right:8px}.mat-simple-snack-bar-content{overflow:hidden;text-overflow:ellipsis}"],encapsulation:2,changeDetection:0}),a})();const g={snackBarState:(0,d.trigger)("state",[(0,d.state)("void, hidden",(0,d.style)({transform:"scale(0.8)",opacity:0})),(0,d.state)("visible",(0,d.style)({transform:"scale(1)",opacity:1})),(0,d.transition)("* => visible",(0,d.animate)("150ms cubic-bezier(0, 0, 0.2, 1)")),(0,d.transition)("* => void, * => hidden",(0,d.animate)("75ms cubic-bezier(0.4, 0.0, 1, 1)",(0,d.style)({opacity:0})))])};let D=(()=>{class a extends _.BasePortalOutlet{constructor(t,n,i,s,r){super(),this._ngZone=t,this._elementRef=n,this._changeDetectorRef=i,this._platform=s,this.snackBarConfig=r,this._announceDelay=150,this._destroyed=!1,this._onAnnounce=new m.x,this._onExit=new m.x,this._onEnter=new m.x,this._animationState="void",this.attachDomPortal=c=>{this._assertNotAttached();const h=this._portalOutlet.attachDomPortal(c);return this._afterPortalAttached(),h},this._live="assertive"!==r.politeness||r.announcementMessage?"off"===r.politeness?"off":"polite":"assertive",this._platform.FIREFOX&&("polite"===this._live&&(this._role="status"),"assertive"===this._live&&(this._role="alert"))}attachComponentPortal(t){this._assertNotAttached();const n=this._portalOutlet.attachComponentPortal(t);return this._afterPortalAttached(),n}attachTemplatePortal(t){this._assertNotAttached();const n=this._portalOutlet.attachTemplatePortal(t);return this._afterPortalAttached(),n}onAnimationEnd(t){const{fromState:n,toState:i}=t;if(("void"===i&&"void"!==n||"hidden"===i)&&this._completeExit(),"visible"===i){const s=this._onEnter;this._ngZone.run(()=>{s.next(),s.complete()})}}enter(){this._destroyed||(this._animationState="visible",this._changeDetectorRef.detectChanges(),this._screenReaderAnnounce())}exit(){return this._ngZone.run(()=>{this._animationState="hidden",this._elementRef.nativeElement.setAttribute("mat-exit",""),clearTimeout(this._announceTimeoutId)}),this._onExit}ngOnDestroy(){this._destroyed=!0,this._completeExit()}_completeExit(){this._ngZone.onMicrotaskEmpty.pipe((0,b.q)(1)).subscribe(()=>{this._ngZone.run(()=>{this._onExit.next(),this._onExit.complete()})})}_afterPortalAttached(){const t=this._elementRef.nativeElement,n=this.snackBarConfig.panelClass;n&&(Array.isArray(n)?n.forEach(i=>t.classList.add(i)):t.classList.add(n))}_assertNotAttached(){this._portalOutlet.hasAttached()}_screenReaderAnnounce(){this._announceTimeoutId||this._ngZone.runOutsideAngular(()=>{this._announceTimeoutId=setTimeout(()=>{const t=this._elementRef.nativeElement.querySelector("[aria-hidden]"),n=this._elementRef.nativeElement.querySelector("[aria-live]");if(t&&n){let i=null;this._platform.isBrowser&&document.activeElement instanceof HTMLElement&&t.contains(document.activeElement)&&(i=document.activeElement),t.removeAttribute("aria-hidden"),n.appendChild(t),i?.focus(),this._onAnnounce.next(),this._onAnnounce.complete()}},this._announceDelay)})}}return a.\u0275fac=function(t){return new(t||a)(e.\u0275\u0275directiveInject(e.NgZone),e.\u0275\u0275directiveInject(e.ElementRef),e.\u0275\u0275directiveInject(e.ChangeDetectorRef),e.\u0275\u0275directiveInject(x.Platform),e.\u0275\u0275directiveInject(u))},a.\u0275dir=e.\u0275\u0275defineDirective({type:a,viewQuery:function(t,n){if(1&t&&e.\u0275\u0275viewQuery(_.CdkPortalOutlet,7),2&t){let i;e.\u0275\u0275queryRefresh(i=e.\u0275\u0275loadQuery())&&(n._portalOutlet=i.first)}},features:[e.\u0275\u0275InheritDefinitionFeature]}),a})(),R=(()=>{class a extends D{_afterPortalAttached(){super._afterPortalAttached(),"center"===this.snackBarConfig.horizontalPosition&&this._elementRef.nativeElement.classList.add("mat-snack-bar-center"),"top"===this.snackBarConfig.verticalPosition&&this._elementRef.nativeElement.classList.add("mat-snack-bar-top")}}return a.\u0275fac=function(){let o;return function(n){return(o||(o=e.\u0275\u0275getInheritedFactory(a)))(n||a)}}(),a.\u0275cmp=e.\u0275\u0275defineComponent({type:a,selectors:[["snack-bar-container"]],hostAttrs:[1,"mat-snack-bar-container"],hostVars:1,hostBindings:function(t,n){1&t&&e.\u0275\u0275syntheticHostListener("@state.done",function(s){return n.onAnimationEnd(s)}),2&t&&e.\u0275\u0275syntheticHostProperty("@state",n._animationState)},features:[e.\u0275\u0275InheritDefinitionFeature],decls:3,vars:2,consts:[["aria-hidden","true"],["cdkPortalOutlet",""]],template:function(t,n){1&t&&(e.\u0275\u0275elementStart(0,"div",0),e.\u0275\u0275template(1,w,0,0,"ng-template",1),e.\u0275\u0275elementEnd(),e.\u0275\u0275element(2,"div")),2&t&&(e.\u0275\u0275advance(2),e.\u0275\u0275attribute("aria-live",n._live)("role",n._role))},dependencies:[_.CdkPortalOutlet],styles:[".mat-snack-bar-container{border-radius:4px;box-sizing:border-box;display:block;margin:24px;max-width:33vw;min-width:344px;padding:14px 16px;min-height:48px;transform-origin:center}.cdk-high-contrast-active .mat-snack-bar-container{border:solid 1px}.mat-snack-bar-handset{width:100%}.mat-snack-bar-handset .mat-snack-bar-container{margin:8px;max-width:100%;min-width:0;width:100%}"],encapsulation:2,data:{animation:[g.snackBarState]}}),a})(),O=(()=>{class a{}return a.\u0275fac=function(t){return new(t||a)},a.\u0275mod=e.\u0275\u0275defineNgModule({type:a}),a.\u0275inj=e.\u0275\u0275defineInjector({imports:[f.OverlayModule,_.PortalModule,A.CommonModule,C.MatButtonModule,S.MatCommonModule,S.MatCommonModule]}),a})();const k=new e.InjectionToken("mat-snack-bar-default-options",{providedIn:"root",factory:P});function P(){return new u}let T=(()=>{class a{constructor(t,n,i,s,r,c){this._overlay=t,this._live=n,this._injector=i,this._breakpointObserver=s,this._parentSnackBar=r,this._defaultConfig=c,this._snackBarRefAtThisLevel=null}get _openedSnackBarRef(){const t=this._parentSnackBar;return t?t._openedSnackBarRef:this._snackBarRefAtThisLevel}set _openedSnackBarRef(t){this._parentSnackBar?this._parentSnackBar._openedSnackBarRef=t:this._snackBarRefAtThisLevel=t}openFromComponent(t,n){return this._attach(t,n)}openFromTemplate(t,n){return this._attach(t,n)}open(t,n="",i){const s={...this._defaultConfig,...i};return s.data={message:t,action:n},s.announcementMessage===t&&(s.announcementMessage=void 0),this.openFromComponent(this.simpleSnackBarComponent,s)}dismiss(){this._openedSnackBarRef&&this._openedSnackBarRef.dismiss()}ngOnDestroy(){this._snackBarRefAtThisLevel&&this._snackBarRefAtThisLevel.dismiss()}_attachSnackBarContainer(t,n){const s=e.Injector.create({parent:n&&n.viewContainerRef&&n.viewContainerRef.injector||this._injector,providers:[{provide:u,useValue:n}]}),r=new _.ComponentPortal(this.snackBarContainerComponent,n.viewContainerRef,s),c=t.attach(r);return c.instance.snackBarConfig=n,c.instance}_attach(t,n){const i={...new u,...this._defaultConfig,...n},s=this._createOverlay(i),r=this._attachSnackBarContainer(s,i),c=new p(r,s);if(t instanceof e.TemplateRef){const h=new _.TemplatePortal(t,null,{$implicit:i.data,snackBarRef:c});c.instance=r.attachTemplatePortal(h)}else{const h=this._createInjector(i,c),K=new _.ComponentPortal(t,void 0,h),U=r.attachComponentPortal(K);c.instance=U.instance}return this._breakpointObserver.observe(v.Breakpoints.HandsetPortrait).pipe((0,I.R)(s.detachments())).subscribe(h=>{s.overlayElement.classList.toggle(this.handsetCssClass,h.matches)}),i.announcementMessage&&r._onAnnounce.subscribe(()=>{this._live.announce(i.announcementMessage,i.politeness)}),this._animateSnackBar(c,i),this._openedSnackBarRef=c,this._openedSnackBarRef}_animateSnackBar(t,n){t.afterDismissed().subscribe(()=>{this._openedSnackBarRef==t&&(this._openedSnackBarRef=null),n.announcementMessage&&this._live.clear()}),this._openedSnackBarRef?(this._openedSnackBarRef.afterDismissed().subscribe(()=>{t.containerInstance.enter()}),this._openedSnackBarRef.dismiss()):t.containerInstance.enter(),n.duration&&n.duration>0&&t.afterOpened().subscribe(()=>t._dismissAfter(n.duration))}_createOverlay(t){const n=new f.OverlayConfig;n.direction=t.direction;let i=this._overlay.position().global();const s="rtl"===t.direction,r="left"===t.horizontalPosition||"start"===t.horizontalPosition&&!s||"end"===t.horizontalPosition&&s,c=!r&&"center"!==t.horizontalPosition;return r?i.left("0"):c?i.right("0"):i.centerHorizontally(),"top"===t.verticalPosition?i.top("0"):i.bottom("0"),n.positionStrategy=i,this._overlay.create(n)}_createInjector(t,n){return e.Injector.create({parent:t&&t.viewContainerRef&&t.viewContainerRef.injector||this._injector,providers:[{provide:p,useValue:n},{provide:B,useValue:t.data}]})}}return a.\u0275fac=function(t){return new(t||a)(e.\u0275\u0275inject(f.Overlay),e.\u0275\u0275inject(y.LiveAnnouncer),e.\u0275\u0275inject(e.Injector),e.\u0275\u0275inject(v.BreakpointObserver),e.\u0275\u0275inject(a,12),e.\u0275\u0275inject(k))},a.\u0275prov=e.\u0275\u0275defineInjectable({token:a,factory:a.\u0275fac}),a})(),F=(()=>{class a extends T{constructor(t,n,i,s,r,c){super(t,n,i,s,r,c),this.simpleSnackBarComponent=E,this.snackBarContainerComponent=R,this.handsetCssClass="mat-snack-bar-handset"}}return a.\u0275fac=function(t){return new(t||a)(e.\u0275\u0275inject(f.Overlay),e.\u0275\u0275inject(y.LiveAnnouncer),e.\u0275\u0275inject(e.Injector),e.\u0275\u0275inject(v.BreakpointObserver),e.\u0275\u0275inject(a,12),e.\u0275\u0275inject(k))},a.\u0275prov=e.\u0275\u0275defineInjectable({token:a,factory:a.\u0275fac,providedIn:O}),a})()}}]);