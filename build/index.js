(()=>{"use strict";var e,r={786:()=>{const e=window.wp.blocks,r=window.React,t=window.wp.i18n,o=window.wp.blockEditor,n=window.wp.components,a=JSON.parse('{"UU":"create-block/category-search"}');(0,e.registerBlockType)(a.UU,{edit:function({attributes:e,setAttributes:a}){const{category:c}=e;return(0,r.createElement)(r.Fragment,null,(0,r.createElement)(o.InspectorControls,null,(0,r.createElement)(n.PanelBody,{title:(0,t.__)("Settings","category-search")},(0,r.createElement)(n.TextControl,{label:(0,t.__)("Category","category-search"),value:c||"",onChange:e=>a({category:e})}))),(0,r.createElement)("p",{...(0,o.useBlockProps)()},"© ",c))}})}},t={};function o(e){var n=t[e];if(void 0!==n)return n.exports;var a=t[e]={exports:{}};return r[e](a,a.exports,o),a.exports}o.m=r,e=[],o.O=(r,t,n,a)=>{if(!t){var c=1/0;for(p=0;p<e.length;p++){t=e[p][0],n=e[p][1],a=e[p][2];for(var l=!0,s=0;s<t.length;s++)(!1&a||c>=a)&&Object.keys(o.O).every((e=>o.O[e](t[s])))?t.splice(s--,1):(l=!1,a<c&&(c=a));if(l){e.splice(p--,1);var i=n();void 0!==i&&(r=i)}}return r}a=a||0;for(var p=e.length;p>0&&e[p-1][2]>a;p--)e[p]=e[p-1];e[p]=[t,n,a]},o.o=(e,r)=>Object.prototype.hasOwnProperty.call(e,r),(()=>{var e={57:0,350:0};o.O.j=r=>0===e[r];var r=(r,t)=>{var n,a,c=t[0],l=t[1],s=t[2],i=0;if(c.some((r=>0!==e[r]))){for(n in l)o.o(l,n)&&(o.m[n]=l[n]);if(s)var p=s(o)}for(r&&r(t);i<c.length;i++)a=c[i],o.o(e,a)&&e[a]&&e[a][0](),e[a]=0;return o.O(p)},t=self.webpackChunkbruceblocks=self.webpackChunkbruceblocks||[];t.forEach(r.bind(null,0)),t.push=r.bind(null,t.push.bind(t))})();var n=o.O(void 0,[350],(()=>o(786)));n=o.O(n)})();