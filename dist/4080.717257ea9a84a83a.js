(self.webpackChunkmaarchCourrier=self.webpackChunkmaarchCourrier||[]).push([[4080],{4080:(F,m,d)=>{d.r(m),d.d(m,{BasePortalHost:()=>C,BasePortalOutlet:()=>l,CdkPortal:()=>p,CdkPortalOutlet:()=>v,ComponentPortal:()=>P,DomPortal:()=>_,DomPortalHost:()=>g,DomPortalOutlet:()=>D,Portal:()=>h,PortalHostDirective:()=>R,PortalInjector:()=>M,PortalModule:()=>E,TemplatePortal:()=>f,TemplatePortalDirective:()=>y});var n=d(5642),w=d(7703);class h{attach(t){return this._attachedHost=t,t.attach(this)}detach(){let t=this._attachedHost;null!=t&&(this._attachedHost=null,t.detach())}get isAttached(){return null!=this._attachedHost}setAttachedHost(t){this._attachedHost=t}}class P extends h{constructor(t,e,r,a){super(),this.component=t,this.viewContainerRef=e,this.injector=r,this.componentFactoryResolver=a}}class f extends h{constructor(t,e,r,a){super(),this.templateRef=t,this.viewContainerRef=e,this.context=r,this.injector=a}get origin(){return this.templateRef.elementRef}attach(t,e=this.context){return this.context=e,super.attach(t)}detach(){return this.context=void 0,super.detach()}}class _ extends h{constructor(t){super(),this.element=t instanceof n.ElementRef?t.nativeElement:t}}class l{constructor(){this._isDisposed=!1,this.attachDomPortal=null}hasAttached(){return!!this._attachedPortal}attach(t){return t instanceof P?(this._attachedPortal=t,this.attachComponentPortal(t)):t instanceof f?(this._attachedPortal=t,this.attachTemplatePortal(t)):this.attachDomPortal&&t instanceof _?(this._attachedPortal=t,this.attachDomPortal(t)):void 0}detach(){this._attachedPortal&&(this._attachedPortal.setAttachedHost(null),this._attachedPortal=null),this._invokeDisposeFn()}dispose(){this.hasAttached()&&this.detach(),this._invokeDisposeFn(),this._isDisposed=!0}setDisposeFn(t){this._disposeFn=t}_invokeDisposeFn(){this._disposeFn&&(this._disposeFn(),this._disposeFn=null)}}class C extends l{}class D extends l{constructor(t,e,r,a,c){super(),this.outletElement=t,this._componentFactoryResolver=e,this._appRef=r,this._defaultInjector=a,this.attachDomPortal=i=>{const s=i.element,u=this._document.createComment("dom-portal");s.parentNode.insertBefore(u,s),this.outletElement.appendChild(s),this._attachedPortal=i,super.setDisposeFn(()=>{u.parentNode&&u.parentNode.replaceChild(s,u)})},this._document=c}attachComponentPortal(t){const r=(t.componentFactoryResolver||this._componentFactoryResolver).resolveComponentFactory(t.component);let a;return t.viewContainerRef?(a=t.viewContainerRef.createComponent(r,t.viewContainerRef.length,t.injector||t.viewContainerRef.injector),this.setDisposeFn(()=>a.destroy())):(a=r.create(t.injector||this._defaultInjector||n.Injector.NULL),this._appRef.attachView(a.hostView),this.setDisposeFn(()=>{this._appRef.viewCount>0&&this._appRef.detachView(a.hostView),a.destroy()})),this.outletElement.appendChild(this._getComponentRootNode(a)),this._attachedPortal=t,a}attachTemplatePortal(t){let e=t.viewContainerRef,r=e.createEmbeddedView(t.templateRef,t.context,{injector:t.injector});return r.rootNodes.forEach(a=>this.outletElement.appendChild(a)),r.detectChanges(),this.setDisposeFn(()=>{let a=e.indexOf(r);-1!==a&&e.remove(a)}),this._attachedPortal=t,r}dispose(){super.dispose(),this.outletElement.remove()}_getComponentRootNode(t){return t.hostView.rootNodes[0]}}class g extends D{}let p=(()=>{class o extends f{constructor(e,r){super(e,r)}}return o.\u0275fac=function(e){return new(e||o)(n.\u0275\u0275directiveInject(n.TemplateRef),n.\u0275\u0275directiveInject(n.ViewContainerRef))},o.\u0275dir=n.\u0275\u0275defineDirective({type:o,selectors:[["","cdkPortal",""]],exportAs:["cdkPortal"],features:[n.\u0275\u0275InheritDefinitionFeature]}),o})(),y=(()=>{class o extends p{}return o.\u0275fac=function(){let t;return function(r){return(t||(t=n.\u0275\u0275getInheritedFactory(o)))(r||o)}}(),o.\u0275dir=n.\u0275\u0275defineDirective({type:o,selectors:[["","cdk-portal",""],["","portal",""]],exportAs:["cdkPortal"],features:[n.\u0275\u0275ProvidersFeature([{provide:p,useExisting:o}]),n.\u0275\u0275InheritDefinitionFeature]}),o})(),v=(()=>{class o extends l{constructor(e,r,a){super(),this._componentFactoryResolver=e,this._viewContainerRef=r,this._isInitialized=!1,this.attached=new n.EventEmitter,this.attachDomPortal=c=>{const i=c.element,s=this._document.createComment("dom-portal");c.setAttachedHost(this),i.parentNode.insertBefore(s,i),this._getRootNode().appendChild(i),this._attachedPortal=c,super.setDisposeFn(()=>{s.parentNode&&s.parentNode.replaceChild(i,s)})},this._document=a}get portal(){return this._attachedPortal}set portal(e){this.hasAttached()&&!e&&!this._isInitialized||(this.hasAttached()&&super.detach(),e&&super.attach(e),this._attachedPortal=e||null)}get attachedRef(){return this._attachedRef}ngOnInit(){this._isInitialized=!0}ngOnDestroy(){super.dispose(),this._attachedPortal=null,this._attachedRef=null}attachComponentPortal(e){e.setAttachedHost(this);const r=null!=e.viewContainerRef?e.viewContainerRef:this._viewContainerRef,c=(e.componentFactoryResolver||this._componentFactoryResolver).resolveComponentFactory(e.component),i=r.createComponent(c,r.length,e.injector||r.injector);return r!==this._viewContainerRef&&this._getRootNode().appendChild(i.hostView.rootNodes[0]),super.setDisposeFn(()=>i.destroy()),this._attachedPortal=e,this._attachedRef=i,this.attached.emit(i),i}attachTemplatePortal(e){e.setAttachedHost(this);const r=this._viewContainerRef.createEmbeddedView(e.templateRef,e.context,{injector:e.injector});return super.setDisposeFn(()=>this._viewContainerRef.clear()),this._attachedPortal=e,this._attachedRef=r,this.attached.emit(r),r}_getRootNode(){const e=this._viewContainerRef.element.nativeElement;return e.nodeType===e.ELEMENT_NODE?e:e.parentNode}}return o.\u0275fac=function(e){return new(e||o)(n.\u0275\u0275directiveInject(n.ComponentFactoryResolver),n.\u0275\u0275directiveInject(n.ViewContainerRef),n.\u0275\u0275directiveInject(w.DOCUMENT))},o.\u0275dir=n.\u0275\u0275defineDirective({type:o,selectors:[["","cdkPortalOutlet",""]],inputs:{portal:["cdkPortalOutlet","portal"]},outputs:{attached:"attached"},exportAs:["cdkPortalOutlet"],features:[n.\u0275\u0275InheritDefinitionFeature]}),o})(),R=(()=>{class o extends v{}return o.\u0275fac=function(){let t;return function(r){return(t||(t=n.\u0275\u0275getInheritedFactory(o)))(r||o)}}(),o.\u0275dir=n.\u0275\u0275defineDirective({type:o,selectors:[["","cdkPortalHost",""],["","portalHost",""]],inputs:{portal:["cdkPortalHost","portal"]},exportAs:["cdkPortalHost"],features:[n.\u0275\u0275ProvidersFeature([{provide:v,useExisting:o}]),n.\u0275\u0275InheritDefinitionFeature]}),o})(),E=(()=>{class o{}return o.\u0275fac=function(e){return new(e||o)},o.\u0275mod=n.\u0275\u0275defineNgModule({type:o}),o.\u0275inj=n.\u0275\u0275defineInjector({}),o})();class M{constructor(t,e){this._parentInjector=t,this._customTokens=e}get(t,e){const r=this._customTokens.get(t);return typeof r<"u"?r:this._parentInjector.get(t,e)}}}}]);