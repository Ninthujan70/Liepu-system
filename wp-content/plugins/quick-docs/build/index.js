!function(){"use strict";var e,t={194:function(){var e=window.wp.blocks,t=window.wp.element,n=window.wp.i18n,r=window.wp.blockEditor,a=window.wp.data,c=window.React;const{Button:o,Card:l,CardHeader:s,CardBody:i}=wp.components;var u=JSON.parse('{"u2":"kumar/quick-docs"}');(0,e.registerBlockType)(u.u2,{edit:function(e){let{attributes:{searchText:u,allContents:d},setAttributes:p,clientId:m}=e;(0,a.useDispatch)();const f=e=>{wp.apiFetch({path:`/quick-doc/api/documents/${e}`}).then((e=>{const t=e?e.content_render:"",n=(new DOMParser).parseFromString(t,"text/html").querySelectorAll("p"),r=Array.from(n).map((e=>e.textContent.trim()));p({allContents:r}),console.log(r)})).catch((e=>{p({allContents:[]})}))};return(0,c.useEffect)((()=>{u&&f(u)}),[u]),[(0,t.createElement)(t.Fragment,null,(0,t.createElement)("div",(0,r.useBlockProps)(),(0,t.createElement)("div",{className:"fast-docs-wrapper"},(0,t.createElement)("div",{className:"fast-docs-header"},"Add Content from Past Documents ",(0,t.createElement)("span",{onClick:()=>{wp.data.dispatch("core/block-editor").removeBlock(m,!1)}},"Close")),(0,t.createElement)("div",{className:"fast-docs-content"},(0,t.createElement)("label",{className:"doc-label"},(0,t.createElement)("b",null,"Document Details")),(0,t.createElement)(r.RichText,{placeholder:(0,n.__)("Enter Doc ID or Name"),value:u,onChange:e=>{p({searchText:e}),f(e)}}),(0,t.createElement)("ul",{className:"all-paragraphs"},d.map(((e,r)=>(0,t.createElement)("li",{key:r,className:"custom-li"},(0,t.createElement)(l,null,(0,t.createElement)(s,null,(0,t.createElement)("p",null,"Paragraph - ",r+1),(0,t.createElement)(o,{variant:"secondary",onClick:()=>(e=>{const t=wp.blocks.createBlock("core/paragraph",{content:e}),n=wp.data.select("core/block-editor").getBlockIndex(m);wp.data.dispatch("core/block-editor").insertBlock(t,n)})(e)},(0,n.__)("Add to Page",""))),(0,t.createElement)(i,null,(0,t.createElement)("p",null,(e=>{const t=e.replace(/(<([^>]+)>)/gi,"");return t.length>200?t.substring(0,200).concat("..."):t})(e))))))),0==d.length?(0,t.createElement)("li",{className:"no-content"},"No any contents Found under the Page ID: ",u):"")))))]},save:function(){return(0,t.createElement)("p",r.useBlockProps.save(),"")}})}},n={};function r(e){var a=n[e];if(void 0!==a)return a.exports;var c=n[e]={exports:{}};return t[e](c,c.exports,r),c.exports}r.m=t,e=[],r.O=function(t,n,a,c){if(!n){var o=1/0;for(u=0;u<e.length;u++){n=e[u][0],a=e[u][1],c=e[u][2];for(var l=!0,s=0;s<n.length;s++)(!1&c||o>=c)&&Object.keys(r.O).every((function(e){return r.O[e](n[s])}))?n.splice(s--,1):(l=!1,c<o&&(o=c));if(l){e.splice(u--,1);var i=a();void 0!==i&&(t=i)}}return t}c=c||0;for(var u=e.length;u>0&&e[u-1][2]>c;u--)e[u]=e[u-1];e[u]=[n,a,c]},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){var e={826:0,431:0};r.O.j=function(t){return 0===e[t]};var t=function(t,n){var a,c,o=n[0],l=n[1],s=n[2],i=0;if(o.some((function(t){return 0!==e[t]}))){for(a in l)r.o(l,a)&&(r.m[a]=l[a]);if(s)var u=s(r)}for(t&&t(n);i<o.length;i++)c=o[i],r.o(e,c)&&e[c]&&e[c][0](),e[c]=0;return r.O(u)},n=self.webpackChunkquick_docs=self.webpackChunkquick_docs||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))}();var a=r.O(void 0,[431],(function(){return r(194)}));a=r.O(a)}();