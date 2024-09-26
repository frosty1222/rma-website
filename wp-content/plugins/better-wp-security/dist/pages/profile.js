/*! For license information please see profile.js.LICENSE.txt */
(globalThis.itsecWebpackJsonP=globalThis.itsecWebpackJsonP||[]).push([[277],{77486:(e,t,n)=>{"use strict";n.r(t),n.d(t,{App:()=>y,UserProfileFill:()=>E});var r=n(6293),s=n(25993),o=n.n(s),i=n(95122),u=n(3571),c=n(64893),a=n(48015),l=n(71930),d=n(31600),p=n(65813),h=n(60976),m=n(52117);const f=(0,m.Z)("div",{target:"eru3znu1"})("display:flex;flex-direction:column;gap:1rem;background:#E9E7EE;margin:1rem 0 1rem -0.625rem;padding:0.625rem;@media screen and (min-width: ",(({theme:e})=>e.breaks.medium),"px){margin:1rem -1.25rem 1rem -1.25rem;padding:1.25rem;}"),w=(0,m.Z)(l.x4,{target:"eru3znu0"})({name:"1jv7dc9",styles:".is-active:after{height:0;}"}),{Slot:v,Fill:E}=(0,c.createSlotFill)("UserProfile"),g=["wp-components-css"];function y({plugins:e,canManage:t,userId:n,useShadow:s}){const{user:o,currentUserId:m}=(0,a.useSelect)((e=>({user:e(d.coreStore).getUser(n),currentUserId:e(d.coreStore).getCurrentUserId()})),[n]),{value:E}=(0,p.r5)((0,r.useCallback)((()=>async function(e,t,n,r){return t?await Promise.allSettled(e.map((e=>Promise.resolve(e.isAvailable(t,n,r)).then((t=>t?e:null))))).then((e=>e.filter((e=>"fulfilled"===e.status&&null!==e.value)).map((e=>e.value)))):Promise.resolve([])}(e,o,m,t)),[e,o,m,t]));if(!E?.length)return null;const y=E.map((e=>({title:e.label,name:e.name,order:e.order}))).sort(((e,t)=>e.order-t.order)),b=(0,r.createElement)(f,null,(0,r.createElement)(l.X6,{level:2,icon:t&&h.Ae,iconSize:"32",text:(0,i.__)("Security","better-wp-security")}),(0,r.createElement)(c.SlotFillProvider,null,(0,r.createElement)(w,{tabs:y},(e=>(0,r.createElement)(v,{fillProps:{name:e.name,canManage:t,userId:n,user:o,useShadow:s}}))),(0,r.createElement)(u.PluginArea,{scope:"solid-security-user-profile"})));return(0,r.createElement)(l.fC,{theme:l.U1},s?(0,r.createElement)(l.os,{children:b,styleSheetIds:g,inherit:!0}):b)}n.p=window.itsecWebpackPublicPath,(0,i.setLocaleData)({"":{}},"ithemes-security-pro"),o()((()=>{const e=document.getElementById("itsec-profile-root"),t=(0,u.getPlugins)("solid-security-user-profile");e&&(0,r.render)((0,r.createElement)(y,{plugins:t,canManage:"1"===e.dataset.canManage,userId:Number.parseInt(e.dataset.user,10)}),document.getElementById("itsec-profile-root"))}))},65813:(e,t,n)=>{"use strict";n.d(t,{r5:()=>f,OR:()=>w,Zk:()=>E,_:()=>g,qq:()=>y,eH:()=>m,gU:()=>c,nP:()=>a,Sj:()=>p,lo:()=>d,vl:()=>i});var r=n(87462),s=n(6293),o=n(9576);function i(e){return(0,o.createHigherOrderComponent)((t=>class extends s.Component{render(){return(0,s.createElement)(t,(0,r.Z)({},this.props,e))}}),"withProps")}var u=n(92819);function c(e,t,n={}){return(0,o.createHigherOrderComponent)((r=>class extends s.Component{constructor(){super(...arguments),this.debouncedPropInvoke=(0,u.debounce)(((...t)=>this.props[e](...t)),"function"==typeof t?t(this.props):t,n),this.handler=(e,...t)=>(e&&"function"==typeof e.persist&&e.persist(),this.debouncedPropInvoke(e,...t))}componentWillUnmount(){this.debouncedPropInvoke.cancel()}render(){const t={...this.props,[e]:this.handler};return(0,s.createElement)(r,t)}}),"withDebounceHandler")}function a(e,t){let n;return n=(0,u.isFunction)(t)?[{delay:e,cb:t}]:e,(0,o.createHigherOrderComponent)((e=>class extends s.Component{constructor(){super(...arguments),this.intervalIds=[]}componentDidMount(){for(const e of n)(t=>{this.intervalIds.push(setInterval((()=>t(this.props)),e.delay))})(e.cb)}componentWillUnmount(){this.intervalIds.forEach(clearInterval)}render(){return(0,s.createElement)(e,this.props)}}),"withInterval")}var l=n(4942);(0,o.createHigherOrderComponent)((e=>{var t;return t=class extends s.Component{constructor(...e){super(...e),(0,l.Z)(this,"state",{width:1280}),(0,l.Z)(this,"mounted",!1),(0,l.Z)(this,"ref",null),(0,l.Z)(this,"onWindowResize",(()=>{if(!this.mounted)return;const e=(0,s.findDOMNode)(this);if(e instanceof window.HTMLElement){const t=e.offsetWidth;this.setState({width:t})}}))}componentDidMount(){this.mounted=!0,window.addEventListener("resize",this.onWindowResize),document.getElementById("collapse-button").addEventListener("click",this.onWindowResize),this.onWindowResize()}componentWillUnmount(){this.mounted=!1,window.removeEventListener("resize",this.onWindowResize),document.getElementById("collapse-button").removeEventListener("click",this.onWindowResize)}render(){const{measureBeforeMount:t,...n}=this.props;return t&&!this.mounted?(0,s.createElement)("div",{className:this.props.className,style:this.props.style}):(0,s.createElement)(e,(0,r.Z)({},n,{width:this.state.width+20}))}},(0,l.Z)(t,"defaultProps",{measureBeforeMount:!1}),t}),"withWidth");const d=(0,o.createHigherOrderComponent)((e=>class extends s.Component{constructor(){super(...arguments),(0,l.Z)(this,"state",{pressed:{shift:!1,ctrl:!1,meta:!1,alt:!1}}),(0,l.Z)(this,"mounted",!1),this.listener=this.listener.bind(this),this.onBlur=this.onBlur.bind(this)}componentDidMount(){this.mounted=!0,window.addEventListener("keydown",this.listener),window.addEventListener("keyup",this.listener),window.addEventListener("click",this.listener),window.addEventListener("blur",this.onBlur)}componentWillUnmount(){this.mounted=!1,window.removeEventListener("keydown",this.listener),window.removeEventListener("keyup",this.listener),window.removeEventListener("click",this.listener),window.removeEventListener("blur",this.onBlur)}listener(e){this.mounted&&this.setState({pressed:{shift:e.shiftKey,ctrl:e.ctrlKey,meta:e.metaKey,alt:e.altKey}})}onBlur(){this.setState({pressed:{shift:!1,ctrl:!1,meta:!1,alt:!1}})}render(){return(0,s.createElement)(e,(0,r.Z)({pressedModifierKeys:this.state.pressed},this.props))}}),"withPressedModifierKeys"),p=(0,o.createHigherOrderComponent)((e=>function({navigate:t,...n}){return(0,s.createElement)(e,(0,r.Z)({},n,{onClick:e=>{try{n.onClick&&n.onClick(e)}catch(t){throw e.preventDefault(),t}e.defaultPrevented||0!==e.button||n.target&&"_self"!==n.target||function(e){return!!(e.metaKey||e.altKey||e.ctrlKey||e.shiftKey)}(e)||(e.preventDefault(),t())}}))}),"withNavigate"),h=new WeakMap;function m(e,t){(0,s.useLayoutEffect)((()=>{h.has(e)||(t(),h.set(e,!0))}),[])}function f(e,t=!0){const[n,r]=(0,s.useState)("idle"),[o,i]=(0,s.useState)(null),[u,c]=(0,s.useState)(null),a=(0,s.useCallback)(((...t)=>(r("pending"),c(null),e(...t).then((e=>{i(e),r("success")})).catch((e=>{c(e),i(null),r("error")})))),[e]);return(0,s.useEffect)((()=>{t&&a()}),[a,t]),{execute:a,status:n,value:o,error:u}}function w(e,t,n=window){const r=(0,s.useRef)();(0,s.useEffect)((()=>{r.current=t}),[t]),(0,s.useEffect)((()=>{if(!n||!n.addEventListener)return;const t=e=>r.current(e);return n.addEventListener(e,t),()=>n.removeEventListener(e,t)}),[e,n])}const v=["button","submit"];function E(e){const t=(0,s.useRef)(e);(0,s.useEffect)((()=>{t.current=e}),[e]);const n=(0,s.useRef)(!1),r=(0,s.useRef)(),o=(0,s.useCallback)((()=>{clearTimeout(r.current)}),[]);(0,s.useEffect)((()=>()=>o()),[]),(0,s.useEffect)((()=>{e||o()}),[e,o]);const i=(0,s.useCallback)((e=>{const{type:t,target:r}=e;(0,u.includes)(["mouseup","touchend"],t)?n.current=!1:function(e){if(!(e instanceof window.HTMLElement))return!1;switch(e.nodeName){case"A":case"BUTTON":return!0;case"INPUT":return(0,u.includes)(v,e.type)}return!1}(r)&&(n.current=!0)}),[]),c=(0,s.useCallback)((e=>{e.persist(),n.current||(r.current=setTimeout((()=>{document.hasFocus()?"function"==typeof t.current&&t.current(e):e.preventDefault()}),0))}),[]);return{onFocus:o,onMouseDown:i,onMouseUp:i,onTouchStart:i,onTouchEnd:i,onBlur:c}}function g(e,t){const[n,r]=(0,s.useState)((()=>{try{const n=window.localStorage.getItem(e);return n?JSON.parse(n):t}catch(e){return console.error(e),t}}));return[n,t=>{try{const s=t instanceof Function?t(n):t;r(s),window.localStorage.setItem(e,JSON.stringify(s))}catch(e){console.error(e)}}]}function y(e){const t=(0,s.useRef)(null),n=(0,s.useRef)(!1),r=(0,s.useRef)(e),o=(0,s.useRef)(e);return o.current=e,(0,s.useLayoutEffect)((()=>{e.forEach(((e,s)=>{const o=r.current[s];"function"==typeof e&&e!==o&&!1===n.current&&(o(null),e(t.current))})),r.current=e}),e),(0,s.useLayoutEffect)((()=>{n.current=!1})),(0,s.useCallback)((e=>{t.current=e,n.current=!0,(e?o.current:r.current).forEach((t=>{"function"==typeof t?t(e):t&&t.hasOwnProperty("current")&&(t.current=e)}))}),[])}n(48015),n(31600)},31600:e=>{e.exports=function(){return this.itsec.packages.data}()},64893:e=>{e.exports=function(){return this.wp.components}()},9576:e=>{e.exports=function(){return this.wp.compose}()},48015:e=>{e.exports=function(){return this.wp.data}()},82521:e=>{e.exports=function(){return this.wp.date}()},25993:e=>{e.exports=function(){return this.wp.domReady}()},6293:e=>{e.exports=function(){return this.wp.element}()},95122:e=>{e.exports=function(){return this.wp.i18n}()},81019:e=>{e.exports=function(){return this.wp.keycodes}()},3571:e=>{e.exports=function(){return this.wp.plugins}()},14776:e=>{e.exports=function(){return this.wp.primitives}()},73470:e=>{e.exports=function(){return this.wp.url}()},99196:e=>{"use strict";e.exports=window.React},92819:e=>{"use strict";e.exports=window.lodash},4942:(e,t,n)=>{"use strict";n.d(t,{Z:()=>s});var r=n(49142);function s(e,t,n){return(t=(0,r.Z)(t))in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}},49142:(e,t,n)=>{"use strict";n.d(t,{Z:()=>s});var r=n(71002);function s(e){var t=function(e,t){if("object"!==(0,r.Z)(e)||null===e)return e;var n=e[Symbol.toPrimitive];if(void 0!==n){var s=n.call(e,"string");if("object"!==(0,r.Z)(s))return s;throw new TypeError("@@toPrimitive must return a primitive value.")}return String(e)}(e);return"symbol"===(0,r.Z)(t)?t:String(t)}}},e=>{e.O(0,[1930,976],(()=>(77486,e(e.s=77486))));var t=e.O();((window.itsec=window.itsec||{}).pages=window.itsec.pages||{}).profile=t}]);