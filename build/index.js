(()=>{"use strict";var e,r={391:()=>{const e=window.wp.blocks,r=window.wp.i18n,t=window.wp.blockEditor,o=window.wp.components,n=window.wp.coreData,s=window.wp.data,i=window.ReactJSXRuntime,c={per_page:-1,context:"view"},a=JSON.parse('{"UU":"create-block/category-search"}');(0,e.registerBlockType)(a.UU,{edit:function({attributes:e,setAttributes:a}){var l;const{categories:p}=e,{categoriesList:u}=(0,s.useSelect)((e=>{const{getEntityRecords:r}=e(n.store);return{categoriesList:r("taxonomy","category",c)}}),[p]),d=null!==(l=u?.reduce(((e,r)=>({...e,[r.name]:r})),{}))&&void 0!==l?l:{};return(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)(t.InspectorControls,{children:(0,i.jsx)(o.PanelBody,{title:(0,r.__)("Sorting and filtering"),children:(0,i.jsx)(o.QueryControls,{categorySuggestions:d,onCategoryChange:e=>{if(e.some((e=>"string"==typeof e&&!d[e])))return;const r=e.map((e=>"string"==typeof e?d[e]:e));if(r.includes(null))return!1;a({categories:r})},selectedCategories:p})})}),(0,i.jsx)("p",{...(0,t.useBlockProps)()})]})}})}},t={};function o(e){var n=t[e];if(void 0!==n)return n.exports;var s=t[e]={exports:{}};return r[e](s,s.exports,o),s.exports}o.m=r,e=[],o.O=(r,t,n,s)=>{if(!t){var i=1/0;for(p=0;p<e.length;p++){t=e[p][0],n=e[p][1],s=e[p][2];for(var c=!0,a=0;a<t.length;a++)(!1&s||i>=s)&&Object.keys(o.O).every((e=>o.O[e](t[a])))?t.splice(a--,1):(c=!1,s<i&&(i=s));if(c){e.splice(p--,1);var l=n();void 0!==l&&(r=l)}}return r}s=s||0;for(var p=e.length;p>0&&e[p-1][2]>s;p--)e[p]=e[p-1];e[p]=[t,n,s]},o.o=(e,r)=>Object.prototype.hasOwnProperty.call(e,r),(()=>{var e={57:0,350:0};o.O.j=r=>0===e[r];var r=(r,t)=>{var n,s,i=t[0],c=t[1],a=t[2],l=0;if(i.some((r=>0!==e[r]))){for(n in c)o.o(c,n)&&(o.m[n]=c[n]);if(a)var p=a(o)}for(r&&r(t);l<i.length;l++)s=i[l],o.o(e,s)&&e[s]&&e[s][0](),e[s]=0;return o.O(p)},t=self.webpackChunkbruceblocks=self.webpackChunkbruceblocks||[];t.forEach(r.bind(null,0)),t.push=r.bind(null,t.push.bind(t))})();var n=o.O(void 0,[350],(()=>o(391)));n=o.O(n)})();