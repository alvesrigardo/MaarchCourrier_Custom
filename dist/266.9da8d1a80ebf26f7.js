(self.webpackChunkmaarchCourrier=self.webpackChunkmaarchCourrier||[]).push([[266,5698],{515:(D,m,o)=>{o.d(m,{E:()=>c});const c=new(o(9751).y)(l=>l.complete())},5698:(D,m,o)=>{o.d(m,{q:()=>s});var p=o(515),c=o(4482),f=o(5403);function s(l){return l<=0?()=>p.E:(0,c.e)((u,y)=>{let d=0;u.subscribe((0,f.x)(y,P=>{++d<=l&&(y.next(P),l<=d&&y.complete())}))})}},2722:(D,m,o)=>{o.d(m,{R:()=>l});var p=o(4482),c=o(5403),f=o(8421),s=o(5032);function l(u){return(0,p.e)((y,d)=>{(0,f.Xf)(u).subscribe((0,c.x)(d,()=>d.complete(),s.Z)),!d.closed&&y.subscribe(d)})}},266:(D,m,o)=>{o.r(m),o.d(m,{MAT_TOOLTIP_DEFAULT_OPTIONS:()=>Y,MAT_TOOLTIP_DEFAULT_OPTIONS_FACTORY:()=>F,MAT_TOOLTIP_SCROLL_STRATEGY:()=>I,MAT_TOOLTIP_SCROLL_STRATEGY_FACTORY:()=>x,MAT_TOOLTIP_SCROLL_STRATEGY_FACTORY_PROVIDER:()=>N,MatTooltip:()=>Z,MatTooltipModule:()=>$,SCROLL_THROTTLE_MS:()=>S,TOOLTIP_PANEL_CLASS:()=>G,TooltipComponent:()=>j,_MatTooltipBase:()=>K,_TooltipComponentBase:()=>W,getMatTooltipInvalidPositionError:()=>X,matTooltipAnimations:()=>Q});var p=o(5571),c=o(528),f=o(7703),s=o(5642),l=o(9836),u=o(1010),y=o(6721),d=o(5600),P=o(2571),b=o(7338),A=o(3827),k=o(4193),L=o(5519),w=o(7579),v=o(2722),V=o(5698),_=o(8365);const H=["tooltip"],S=20,G="mat-tooltip-panel",B="tooltip-panel",U=(0,A.normalizePassiveListenerOptions)({passive:!0});function X(n){return Error(`Tooltip position "${n}" is invalid.`)}const I=new s.InjectionToken("mat-tooltip-scroll-strategy");function x(n){return()=>n.scrollStrategies.reposition({scrollThrottle:S})}const N={provide:I,deps:[p.Overlay],useFactory:x},Y=new s.InjectionToken("mat-tooltip-default-options",{providedIn:"root",factory:F});function F(){return{showDelay:0,hideDelay:0,touchendHideDelay:1500}}let K=(()=>{class n{constructor(t,e,i,a,r,g,E,M,C,O,T,R){this._overlay=t,this._elementRef=e,this._scrollDispatcher=i,this._viewContainerRef=a,this._ngZone=r,this._platform=g,this._ariaDescriber=E,this._focusMonitor=M,this._dir=O,this._defaultOptions=T,this._position="below",this._disabled=!1,this._viewInitialized=!1,this._pointerExitEventsInitialized=!1,this._viewportMargin=8,this._cssClassPrefix="mat",this._showDelay=this._defaultOptions.showDelay,this._hideDelay=this._defaultOptions.hideDelay,this.touchGestures="auto",this._message="",this._passiveListeners=[],this._destroyed=new w.x,this._scrollStrategy=C,this._document=R,T&&(T.position&&(this.position=T.position),T.touchGestures&&(this.touchGestures=T.touchGestures)),O.change.pipe((0,v.R)(this._destroyed)).subscribe(()=>{this._overlayRef&&this._updatePosition(this._overlayRef)})}get position(){return this._position}set position(t){t!==this._position&&(this._position=t,this._overlayRef&&(this._updatePosition(this._overlayRef),this._tooltipInstance?.show(0),this._overlayRef.updatePosition()))}get disabled(){return this._disabled}set disabled(t){this._disabled=(0,d.coerceBooleanProperty)(t),this._disabled?this.hide(0):this._setupPointerEnterEventsIfNeeded()}get showDelay(){return this._showDelay}set showDelay(t){this._showDelay=(0,d.coerceNumberProperty)(t)}get hideDelay(){return this._hideDelay}set hideDelay(t){this._hideDelay=(0,d.coerceNumberProperty)(t),this._tooltipInstance&&(this._tooltipInstance._mouseLeaveHideDelay=this._hideDelay)}get message(){return this._message}set message(t){this._ariaDescriber.removeDescription(this._elementRef.nativeElement,this._message,"tooltip"),this._message=null!=t?String(t).trim():"",!this._message&&this._isTooltipVisible()?this.hide(0):(this._setupPointerEnterEventsIfNeeded(),this._updateTooltipMessage(),this._ngZone.runOutsideAngular(()=>{Promise.resolve().then(()=>{this._ariaDescriber.describe(this._elementRef.nativeElement,this.message,"tooltip")})}))}get tooltipClass(){return this._tooltipClass}set tooltipClass(t){this._tooltipClass=t,this._tooltipInstance&&this._setTooltipClass(this._tooltipClass)}ngAfterViewInit(){this._viewInitialized=!0,this._setupPointerEnterEventsIfNeeded(),this._focusMonitor.monitor(this._elementRef).pipe((0,v.R)(this._destroyed)).subscribe(t=>{t?"keyboard"===t&&this._ngZone.run(()=>this.show()):this._ngZone.run(()=>this.hide(0))})}ngOnDestroy(){const t=this._elementRef.nativeElement;clearTimeout(this._touchstartTimeout),this._overlayRef&&(this._overlayRef.dispose(),this._tooltipInstance=null),this._passiveListeners.forEach(([e,i])=>{t.removeEventListener(e,i,U)}),this._passiveListeners.length=0,this._destroyed.next(),this._destroyed.complete(),this._ariaDescriber.removeDescription(t,this.message,"tooltip"),this._focusMonitor.stopMonitoring(t)}show(t=this.showDelay){if(this.disabled||!this.message||this._isTooltipVisible())return void this._tooltipInstance?._cancelPendingAnimations();const e=this._createOverlay();this._detach(),this._portal=this._portal||new k.ComponentPortal(this._tooltipComponent,this._viewContainerRef);const i=this._tooltipInstance=e.attach(this._portal).instance;i._triggerElement=this._elementRef.nativeElement,i._mouseLeaveHideDelay=this._hideDelay,i.afterHidden().pipe((0,v.R)(this._destroyed)).subscribe(()=>this._detach()),this._setTooltipClass(this._tooltipClass),this._updateTooltipMessage(),i.show(t)}hide(t=this.hideDelay){const e=this._tooltipInstance;e&&(e.isVisible()?e.hide(t):(e._cancelPendingAnimations(),this._detach()))}toggle(){this._isTooltipVisible()?this.hide():this.show()}_isTooltipVisible(){return!!this._tooltipInstance&&this._tooltipInstance.isVisible()}_createOverlay(){if(this._overlayRef)return this._overlayRef;const t=this._scrollDispatcher.getAncestorScrollContainers(this._elementRef),e=this._overlay.position().flexibleConnectedTo(this._elementRef).withTransformOriginOn(`.${this._cssClassPrefix}-tooltip`).withFlexibleDimensions(!1).withViewportMargin(this._viewportMargin).withScrollableContainers(t);return e.positionChanges.pipe((0,v.R)(this._destroyed)).subscribe(i=>{this._updateCurrentPositionClass(i.connectionPair),this._tooltipInstance&&i.scrollableViewProperties.isOverlayClipped&&this._tooltipInstance.isVisible()&&this._ngZone.run(()=>this.hide(0))}),this._overlayRef=this._overlay.create({direction:this._dir,positionStrategy:e,panelClass:`${this._cssClassPrefix}-${B}`,scrollStrategy:this._scrollStrategy()}),this._updatePosition(this._overlayRef),this._overlayRef.detachments().pipe((0,v.R)(this._destroyed)).subscribe(()=>this._detach()),this._overlayRef.outsidePointerEvents().pipe((0,v.R)(this._destroyed)).subscribe(()=>this._tooltipInstance?._handleBodyInteraction()),this._overlayRef.keydownEvents().pipe((0,v.R)(this._destroyed)).subscribe(i=>{this._isTooltipVisible()&&i.keyCode===P.ESCAPE&&!(0,P.hasModifierKey)(i)&&(i.preventDefault(),i.stopPropagation(),this._ngZone.run(()=>this.hide(0)))}),this._defaultOptions?.disableTooltipInteractivity&&this._overlayRef.addPanelClass(`${this._cssClassPrefix}-tooltip-panel-non-interactive`),this._overlayRef}_detach(){this._overlayRef&&this._overlayRef.hasAttached()&&this._overlayRef.detach(),this._tooltipInstance=null}_updatePosition(t){const e=t.getConfig().positionStrategy,i=this._getOrigin(),a=this._getOverlayPosition();e.withPositions([this._addOffset({...i.main,...a.main}),this._addOffset({...i.fallback,...a.fallback})])}_addOffset(t){return t}_getOrigin(){const t=!this._dir||"ltr"==this._dir.value,e=this.position;let i;"above"==e||"below"==e?i={originX:"center",originY:"above"==e?"top":"bottom"}:"before"==e||"left"==e&&t||"right"==e&&!t?i={originX:"start",originY:"center"}:("after"==e||"right"==e&&t||"left"==e&&!t)&&(i={originX:"end",originY:"center"});const{x:a,y:r}=this._invertPosition(i.originX,i.originY);return{main:i,fallback:{originX:a,originY:r}}}_getOverlayPosition(){const t=!this._dir||"ltr"==this._dir.value,e=this.position;let i;"above"==e?i={overlayX:"center",overlayY:"bottom"}:"below"==e?i={overlayX:"center",overlayY:"top"}:"before"==e||"left"==e&&t||"right"==e&&!t?i={overlayX:"end",overlayY:"center"}:("after"==e||"right"==e&&t||"left"==e&&!t)&&(i={overlayX:"start",overlayY:"center"});const{x:a,y:r}=this._invertPosition(i.overlayX,i.overlayY);return{main:i,fallback:{overlayX:a,overlayY:r}}}_updateTooltipMessage(){this._tooltipInstance&&(this._tooltipInstance.message=this.message,this._tooltipInstance._markForCheck(),this._ngZone.onMicrotaskEmpty.pipe((0,V.q)(1),(0,v.R)(this._destroyed)).subscribe(()=>{this._tooltipInstance&&this._overlayRef.updatePosition()}))}_setTooltipClass(t){this._tooltipInstance&&(this._tooltipInstance.tooltipClass=t,this._tooltipInstance._markForCheck())}_invertPosition(t,e){return"above"===this.position||"below"===this.position?"top"===e?e="bottom":"bottom"===e&&(e="top"):"end"===t?t="start":"start"===t&&(t="end"),{x:t,y:e}}_updateCurrentPositionClass(t){const{overlayY:e,originX:i,originY:a}=t;let r;if(r="center"===e?this._dir&&"rtl"===this._dir.value?"end"===i?"left":"right":"start"===i?"left":"right":"bottom"===e&&"top"===a?"above":"below",r!==this._currentPosition){const g=this._overlayRef;if(g){const E=`${this._cssClassPrefix}-${B}-`;g.removePanelClass(E+this._currentPosition),g.addPanelClass(E+r)}this._currentPosition=r}}_setupPointerEnterEventsIfNeeded(){this._disabled||!this.message||!this._viewInitialized||this._passiveListeners.length||(this._platformSupportsMouseEvents()?this._passiveListeners.push(["mouseenter",()=>{this._setupPointerExitEventsIfNeeded(),this.show()}]):"off"!==this.touchGestures&&(this._disableNativeGesturesIfNecessary(),this._passiveListeners.push(["touchstart",()=>{this._setupPointerExitEventsIfNeeded(),clearTimeout(this._touchstartTimeout),this._touchstartTimeout=setTimeout(()=>this.show(),500)}])),this._addListeners(this._passiveListeners))}_setupPointerExitEventsIfNeeded(){if(this._pointerExitEventsInitialized)return;this._pointerExitEventsInitialized=!0;const t=[];if(this._platformSupportsMouseEvents())t.push(["mouseleave",e=>{const i=e.relatedTarget;(!i||!this._overlayRef?.overlayElement.contains(i))&&this.hide()}],["wheel",e=>this._wheelListener(e)]);else if("off"!==this.touchGestures){this._disableNativeGesturesIfNecessary();const e=()=>{clearTimeout(this._touchstartTimeout),this.hide(this._defaultOptions.touchendHideDelay)};t.push(["touchend",e],["touchcancel",e])}this._addListeners(t),this._passiveListeners.push(...t)}_addListeners(t){t.forEach(([e,i])=>{this._elementRef.nativeElement.addEventListener(e,i,U)})}_platformSupportsMouseEvents(){return!this._platform.IOS&&!this._platform.ANDROID}_wheelListener(t){if(this._isTooltipVisible()){const e=this._document.elementFromPoint(t.clientX,t.clientY),i=this._elementRef.nativeElement;e!==i&&!i.contains(e)&&this.hide()}}_disableNativeGesturesIfNecessary(){const t=this.touchGestures;if("off"!==t){const e=this._elementRef.nativeElement,i=e.style;("on"===t||"INPUT"!==e.nodeName&&"TEXTAREA"!==e.nodeName)&&(i.userSelect=i.msUserSelect=i.webkitUserSelect=i.MozUserSelect="none"),("on"===t||!e.draggable)&&(i.webkitUserDrag="none"),i.touchAction="none",i.webkitTapHighlightColor="transparent"}}}return n.\u0275fac=function(t){s.\u0275\u0275invalidFactory()},n.\u0275dir=s.\u0275\u0275defineDirective({type:n,inputs:{position:["matTooltipPosition","position"],disabled:["matTooltipDisabled","disabled"],showDelay:["matTooltipShowDelay","showDelay"],hideDelay:["matTooltipHideDelay","hideDelay"],touchGestures:["matTooltipTouchGestures","touchGestures"],message:["matTooltip","message"],tooltipClass:["matTooltipClass","tooltipClass"]}}),n})(),Z=(()=>{class n extends K{constructor(t,e,i,a,r,g,E,M,C,O,T,R){super(t,e,i,a,r,g,E,M,C,O,T,R),this._tooltipComponent=j}}return n.\u0275fac=function(t){return new(t||n)(s.\u0275\u0275directiveInject(p.Overlay),s.\u0275\u0275directiveInject(s.ElementRef),s.\u0275\u0275directiveInject(u.ScrollDispatcher),s.\u0275\u0275directiveInject(s.ViewContainerRef),s.\u0275\u0275directiveInject(s.NgZone),s.\u0275\u0275directiveInject(A.Platform),s.\u0275\u0275directiveInject(c.AriaDescriber),s.\u0275\u0275directiveInject(c.FocusMonitor),s.\u0275\u0275directiveInject(I),s.\u0275\u0275directiveInject(y.Directionality,8),s.\u0275\u0275directiveInject(Y,8),s.\u0275\u0275directiveInject(f.DOCUMENT))},n.\u0275dir=s.\u0275\u0275defineDirective({type:n,selectors:[["","matTooltip",""]],hostAttrs:[1,"mat-tooltip-trigger"],exportAs:["matTooltip"],features:[s.\u0275\u0275InheritDefinitionFeature]}),n})(),W=(()=>{class n{constructor(t,e){this._changeDetectorRef=t,this._closeOnInteraction=!1,this._isVisible=!1,this._onHide=new w.x,this._animationsDisabled="NoopAnimations"===e}show(t){clearTimeout(this._hideTimeoutId),this._showTimeoutId=setTimeout(()=>{this._toggleVisibility(!0),this._showTimeoutId=void 0},t)}hide(t){clearTimeout(this._showTimeoutId),this._hideTimeoutId=setTimeout(()=>{this._toggleVisibility(!1),this._hideTimeoutId=void 0},t)}afterHidden(){return this._onHide}isVisible(){return this._isVisible}ngOnDestroy(){this._cancelPendingAnimations(),this._onHide.complete(),this._triggerElement=null}_handleBodyInteraction(){this._closeOnInteraction&&this.hide(0)}_markForCheck(){this._changeDetectorRef.markForCheck()}_handleMouseLeave({relatedTarget:t}){(!t||!this._triggerElement.contains(t))&&(this.isVisible()?this.hide(this._mouseLeaveHideDelay):this._finalizeAnimation(!1))}_onShow(){}_handleAnimationEnd({animationName:t}){(t===this._showAnimation||t===this._hideAnimation)&&this._finalizeAnimation(t===this._showAnimation)}_cancelPendingAnimations(){clearTimeout(this._showTimeoutId),clearTimeout(this._hideTimeoutId),this._showTimeoutId=this._hideTimeoutId=void 0}_finalizeAnimation(t){t?this._closeOnInteraction=!0:this.isVisible()||this._onHide.next()}_toggleVisibility(t){const e=this._tooltip.nativeElement,i=this._showAnimation,a=this._hideAnimation;if(e.classList.remove(t?a:i),e.classList.add(t?i:a),this._isVisible=t,t&&!this._animationsDisabled&&"function"==typeof getComputedStyle){const r=getComputedStyle(e);("0s"===r.getPropertyValue("animation-duration")||"none"===r.getPropertyValue("animation-name"))&&(this._animationsDisabled=!0)}t&&this._onShow(),this._animationsDisabled&&(e.classList.add("_mat-animation-noopable"),this._finalizeAnimation(t))}}return n.\u0275fac=function(t){return new(t||n)(s.\u0275\u0275directiveInject(s.ChangeDetectorRef),s.\u0275\u0275directiveInject(L.ANIMATION_MODULE_TYPE,8))},n.\u0275dir=s.\u0275\u0275defineDirective({type:n}),n})(),j=(()=>{class n extends W{constructor(t,e,i){super(t,i),this._breakpointObserver=e,this._isHandset=this._breakpointObserver.observe(b.Breakpoints.Handset),this._showAnimation="mat-tooltip-show",this._hideAnimation="mat-tooltip-hide"}}return n.\u0275fac=function(t){return new(t||n)(s.\u0275\u0275directiveInject(s.ChangeDetectorRef),s.\u0275\u0275directiveInject(b.BreakpointObserver),s.\u0275\u0275directiveInject(L.ANIMATION_MODULE_TYPE,8))},n.\u0275cmp=s.\u0275\u0275defineComponent({type:n,selectors:[["mat-tooltip-component"]],viewQuery:function(t,e){if(1&t&&s.\u0275\u0275viewQuery(H,7),2&t){let i;s.\u0275\u0275queryRefresh(i=s.\u0275\u0275loadQuery())&&(e._tooltip=i.first)}},hostAttrs:["aria-hidden","true"],hostVars:2,hostBindings:function(t,e){1&t&&s.\u0275\u0275listener("mouseleave",function(a){return e._handleMouseLeave(a)}),2&t&&s.\u0275\u0275styleProp("zoom",e.isVisible()?1:null)},features:[s.\u0275\u0275InheritDefinitionFeature],decls:4,vars:6,consts:[[1,"mat-tooltip",3,"ngClass","animationend"],["tooltip",""]],template:function(t,e){if(1&t&&(s.\u0275\u0275elementStart(0,"div",0,1),s.\u0275\u0275listener("animationend",function(a){return e._handleAnimationEnd(a)}),s.\u0275\u0275pipe(2,"async"),s.\u0275\u0275text(3),s.\u0275\u0275elementEnd()),2&t){let i;s.\u0275\u0275classProp("mat-tooltip-handset",null==(i=s.\u0275\u0275pipeBind1(2,4,e._isHandset))?null:i.matches),s.\u0275\u0275property("ngClass",e.tooltipClass),s.\u0275\u0275advance(3),s.\u0275\u0275textInterpolate(e.message)}},dependencies:[f.NgClass,f.AsyncPipe],styles:[".mat-tooltip{color:#fff;border-radius:4px;margin:14px;max-width:250px;padding-left:8px;padding-right:8px;overflow:hidden;text-overflow:ellipsis;transform:scale(0)}.mat-tooltip._mat-animation-noopable{animation:none;transform:scale(1)}.cdk-high-contrast-active .mat-tooltip{outline:solid 1px}.mat-tooltip-handset{margin:24px;padding-left:16px;padding-right:16px}.mat-tooltip-panel-non-interactive{pointer-events:none}@keyframes mat-tooltip-show{0%{opacity:0;transform:scale(0)}50%{opacity:.5;transform:scale(0.99)}100%{opacity:1;transform:scale(1)}}@keyframes mat-tooltip-hide{0%{opacity:1;transform:scale(1)}100%{opacity:0;transform:scale(1)}}.mat-tooltip-show{animation:mat-tooltip-show 200ms cubic-bezier(0, 0, 0.2, 1) forwards}.mat-tooltip-hide{animation:mat-tooltip-hide 100ms cubic-bezier(0, 0, 0.2, 1) forwards}"],encapsulation:2,changeDetection:0}),n})(),$=(()=>{class n{}return n.\u0275fac=function(t){return new(t||n)},n.\u0275mod=s.\u0275\u0275defineNgModule({type:n}),n.\u0275inj=s.\u0275\u0275defineInjector({providers:[N],imports:[c.A11yModule,f.CommonModule,p.OverlayModule,l.MatCommonModule,l.MatCommonModule,u.CdkScrollableModule]}),n})();const Q={tooltipState:(0,_.trigger)("state",[(0,_.state)("initial, void, hidden",(0,_.style)({opacity:0,transform:"scale(0)"})),(0,_.state)("visible",(0,_.style)({transform:"scale(1)"})),(0,_.transition)("* => visible",(0,_.animate)("200ms cubic-bezier(0, 0, 0.2, 1)",(0,_.keyframes)([(0,_.style)({opacity:0,transform:"scale(0)",offset:0}),(0,_.style)({opacity:.5,transform:"scale(0.99)",offset:.5}),(0,_.style)({opacity:1,transform:"scale(1)",offset:1})]))),(0,_.transition)("* => hidden",(0,_.animate)("100ms cubic-bezier(0, 0, 0.2, 1)",(0,_.style)({opacity:0})))])}}}]);