// import StickySidebar from 'sticky-sidebar-v2';

// const SIDEBAR_SELECTOR = '.sidebar';

// let sidebar;

// const handleLoad = () => {
//   // console.log('*** HANDLE LOAD...');
//   const sidebarElem = document.querySelector(SIDEBAR_SELECTOR);

//   console.log('sidebarElem: ', sidebarElem);

//   if (sidebar) {
//     // console.log('$$$$$$$$ DESTROY SIDEBAR');
//     sidebar.destroy();
//   }

//   if (!sidebarElem) {
//     return;
//   }

//   // if (sidebar) {
//   //   console.log('UPDATE STICKY...', sidebar);
//   //   window.requestAnimationFrame(() => {
//   //     sidebar.updateSticky();
//   //   })
    
//   //   return;
//   // }

//   const sidebarTop = parseFloat(getComputedStyle(sidebarElem).getPropertyValue('--sidebar-top'));

//   // console.log('§§§§§§§ INIT sidebarElem: ', sidebarTop);
//   sidebar = new StickySidebar(sidebarElem, {
//     topSpacing: sidebarTop,
//     bottomSpacing: 24,
//     containerSelector: '.sidebar-container',
//     innerWrapperSelector: '.sidebar-body'
//   });

//   console.log('sidebar: ', sidebar);

//   // console.log('sidebar:', sidebar);
//   // const handleLoad = () => {
//   //   if (!document.contains(sidebarElem)) {
//   //     console.log('DESTROY...');
//   //   }
//   // }
// }

// const handleUnload = () => {
//   if (sidebar) {
//     sidebar.destroy();
//   }
// }

// // document.addEventListener('turbo:load', initSidebar);
// // document.addEventListener('DOMContentLoaded', initSidebar);
// document.addEventListener('DOMContentLoaded', handleLoad);
// document.addEventListener('turbo:render', handleLoad);
// // document.addEventListener('turbo:before-render', handleUnload);
