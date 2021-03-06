/* Load this script using conditional IE comments if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'alpona\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-home' : '&#xe000;',
			'icon-home-2' : '&#xe001;',
			'icon-office' : '&#xe002;',
			'icon-newspaper' : '&#xe003;',
			'icon-pencil' : '&#xe004;',
			'icon-pencil-2' : '&#xe005;',
			'icon-pencil-3' : '&#xe006;',
			'icon-pen' : '&#xe007;',
			'icon-pen-2' : '&#xe008;',
			'icon-brush' : '&#xe009;',
			'icon-palette' : '&#xe00a;',
			'icon-eyedropper' : '&#xe00b;',
			'icon-droplet' : '&#xe00c;',
			'icon-image' : '&#xe00d;',
			'icon-image-2' : '&#xe00e;',
			'icon-images' : '&#xe00f;',
			'icon-image-3' : '&#xe010;',
			'icon-images-2' : '&#xe011;',
			'icon-camera' : '&#xe012;',
			'icon-camera-2' : '&#xe013;',
			'icon-music' : '&#xe014;',
			'icon-camera-3' : '&#xe015;',
			'icon-camera-4' : '&#xe016;',
			'icon-film' : '&#xe017;',
			'icon-movie' : '&#xe018;',
			'icon-movie-2' : '&#xe019;',
			'icon-movie-3' : '&#xe01a;',
			'icon-play' : '&#xe01b;',
			'icon-headphones' : '&#xe01c;',
			'icon-headphones-2' : '&#xe01d;',
			'icon-gamepad' : '&#xe01e;',
			'icon-pacman' : '&#xe01f;',
			'icon-king' : '&#xe020;',
			'icon-bullhorn' : '&#xe021;',
			'icon-new' : '&#xe022;',
			'icon-radio' : '&#xe023;',
			'icon-connection' : '&#xe024;',
			'icon-radio-2' : '&#xe025;',
			'icon-mic' : '&#xe026;',
			'icon-connection-2' : '&#xe027;',
			'icon-podcast' : '&#xe028;',
			'icon-mic-2' : '&#xe029;',
			'icon-mic-3' : '&#xe02a;',
			'icon-book' : '&#xe02b;',
			'icon-books' : '&#xe02d;',
			'icon-graduation' : '&#xe02e;',
			'icon-file' : '&#xe02f;',
			'icon-profile' : '&#xe030;',
			'icon-file-2' : '&#xe031;',
			'icon-file-3' : '&#xe032;',
			'icon-file-4' : '&#xe033;',
			'icon-file-5' : '&#xe034;',
			'icon-file-6' : '&#xe035;',
			'icon-files' : '&#xe036;',
			'icon-file-plus' : '&#xe037;',
			'icon-file-minus' : '&#xe038;',
			'icon-file-download' : '&#xe039;',
			'icon-file-upload' : '&#xe03a;',
			'icon-file-check' : '&#xe03b;',
			'icon-file-remove' : '&#xe03c;',
			'icon-file-7' : '&#xe03d;',
			'icon-file-8' : '&#xe03e;',
			'icon-file-plus-2' : '&#xe03f;',
			'icon-file-minus-2' : '&#xe040;',
			'icon-file-download-2' : '&#xe041;',
			'icon-file-upload-2' : '&#xe042;',
			'icon-file-check-2' : '&#xe043;',
			'icon-file-remove-2' : '&#xe044;',
			'icon-file-9' : '&#xe045;',
			'icon-copy' : '&#xe046;',
			'icon-copy-2' : '&#xe047;',
			'icon-copy-3' : '&#xe048;',
			'icon-copy-4' : '&#xe049;',
			'icon-paste' : '&#xe04a;',
			'icon-paste-2' : '&#xe04b;',
			'icon-paste-3' : '&#xe04c;',
			'icon-folder' : '&#xe04d;',
			'icon-folder-download' : '&#xe04e;',
			'icon-folder-upload' : '&#xe04f;',
			'icon-folder-plus' : '&#xe050;',
			'icon-folder-plus-2' : '&#xe051;',
			'icon-folder-minus' : '&#xe052;',
			'icon-folder-minus-2' : '&#xe053;',
			'icon-folder8' : '&#xe054;',
			'icon-folder-remove' : '&#xe055;',
			'icon-folder-2' : '&#xe056;',
			'icon-folder-open' : '&#xe057;',
			'icon-folder-plus-3' : '&#xe05a;',
			'icon-folder-minus-3' : '&#xe05b;',
			'icon-folder-download-2' : '&#xe05e;',
			'icon-folder-upload-2' : '&#xe05f;',
			'icon-folder-3' : '&#xe058;',
			'icon-folder-open-2' : '&#xe059;',
			'icon-certificate' : '&#xe05c;',
			'icon-cc' : '&#xe05d;',
			'icon-tag' : '&#xe060;',
			'icon-tags' : '&#xe061;',
			'icon-tags-2' : '&#xe062;',
			'icon-tag-2' : '&#xe063;',
			'icon-barcode' : '&#xe064;',
			'icon-qrcode' : '&#xe065;',
			'icon-cart' : '&#xe066;',
			'icon-cart-2' : '&#xe067;',
			'icon-cart-3' : '&#xe068;',
			'icon-cart-plus' : '&#xe069;',
			'icon-cart-minus' : '&#xe06a;',
			'icon-cart-add' : '&#xe06b;',
			'icon-cart-remove' : '&#xe06c;',
			'icon-cart-checkout' : '&#xe06d;',
			'icon-cart-remove-2' : '&#xe06e;',
			'icon-basket' : '&#xe06f;',
			'icon-basket-2' : '&#xe070;',
			'icon-bag' : '&#xe071;',
			'icon-bag-2' : '&#xe072;',
			'icon-bag-3' : '&#xe073;',
			'icon-coin' : '&#xe074;',
			'icon-credit' : '&#xe075;',
			'icon-credit-2' : '&#xe076;',
			'icon-calculate' : '&#xe077;',
			'icon-calculate-2' : '&#xe078;',
			'icon-support' : '&#xe079;',
			'icon-phone' : '&#xe07a;',
			'icon-contact-add' : '&#xe07b;',
			'icon-contact-remove' : '&#xe07c;',
			'icon-address-book' : '&#xe07d;',
			'icon-address-book-2' : '&#xe07e;',
			'icon-notebook' : '&#xe07f;',
			'icon-envelop' : '&#xe080;',
			'icon-envelop-opened' : '&#xe081;',
			'icon-pushpin' : '&#xe082;',
			'icon-location' : '&#xe083;',
			'icon-location-2' : '&#xe084;',
			'icon-location-3' : '&#xe085;',
			'icon-location-4' : '&#xe086;',
			'icon-compass' : '&#xe087;',
			'icon-direction' : '&#xe088;',
			'icon-clock' : '&#xe089;',
			'icon-clock-2' : '&#xe08a;',
			'icon-clock-3' : '&#xe08b;',
			'icon-alarm' : '&#xe08c;',
			'icon-alarm-2' : '&#xe08d;',
			'icon-bell' : '&#xe08e;',
			'icon-alarm-plus' : '&#xe08f;',
			'icon-alarm-minus' : '&#xe090;',
			'icon-alarm-check' : '&#xe091;',
			'icon-alarm-cancel' : '&#xe092;',
			'icon-stopwatch' : '&#xe093;',
			'icon-calendar' : '&#xe094;',
			'icon-calendar-2' : '&#xe095;',
			'icon-calendar-3' : '&#xe096;',
			'icon-calendar-4' : '&#xe097;',
			'icon-calendar-5' : '&#xe098;',
			'icon-print' : '&#xe099;',
			'icon-print-2' : '&#xe09a;',
			'icon-print-3' : '&#xe09b;',
			'icon-mouse' : '&#xe09c;',
			'icon-mouse-2' : '&#xe09d;',
			'icon-mouse-3' : '&#xe09e;',
			'icon-keyboard' : '&#xe09f;',
			'icon-screen' : '&#xe0a0;',
			'icon-screen-2' : '&#xe0a1;',
			'icon-screen-3' : '&#xe0a2;',
			'icon-laptop' : '&#xe0a3;',
			'icon-mobile' : '&#xe0a4;',
			'icon-mobile-2' : '&#xe0a5;',
			'icon-tablet' : '&#xe0a6;',
			'icon-mobile-3' : '&#xe0a7;',
			'icon-tv' : '&#xe0a8;',
			'icon-cabinet' : '&#xe0a9;',
			'icon-archive' : '&#xe0aa;',
			'icon-box-add' : '&#xe0ab;',
			'icon-box-remove' : '&#xe0ac;',
			'icon-download' : '&#xe0ad;',
			'icon-upload' : '&#xe0ae;',
			'icon-disk' : '&#xe0af;',
			'icon-cd' : '&#xe0b0;',
			'icon-storage' : '&#xe0b1;',
			'icon-database' : '&#xe0b2;',
			'icon-rotate' : '&#xe0b3;',
			'icon-rotate-2' : '&#xe0b4;',
			'icon-undo' : '&#xe0b5;',
			'icon-redo' : '&#xe0b6;',
			'icon-forward' : '&#xe0b7;',
			'icon-reply' : '&#xe0b8;',
			'icon-reply-2' : '&#xe0b9;',
			'icon-bubble' : '&#xe0ba;',
			'icon-bubbles' : '&#xe0bb;',
			'icon-bubbles-2' : '&#xe0bc;',
			'icon-bubble-2' : '&#xe0bd;',
			'icon-bubbles-3' : '&#xe0be;',
			'icon-bubbles-4' : '&#xe0bf;',
			'icon-bubble-notification' : '&#xe0c0;',
			'icon-bubbles-5' : '&#xe0c1;',
			'icon-bubbles-6' : '&#xe0c2;',
			'icon-bubble-3' : '&#xe0c3;',
			'icon-bubble-dots' : '&#xe0c4;',
			'icon-bubble-4' : '&#xe0c5;',
			'icon-bubble-5' : '&#xe0c6;',
			'icon-bubble-dots-2' : '&#xe0c7;',
			'icon-bubble-6' : '&#xe0c8;',
			'icon-bubble-7' : '&#xe0c9;',
			'icon-bubble-8' : '&#xe0ca;',
			'icon-bubbles-7' : '&#xe0cb;',
			'icon-bubble-9' : '&#xe0cc;',
			'icon-bubbles-8' : '&#xe0cd;',
			'icon-bubble-10' : '&#xe0ce;',
			'icon-bubble-dots-3' : '&#xe0cf;',
			'icon-bubble-11' : '&#xe0d0;',
			'icon-bubble-12' : '&#xe0d1;',
			'icon-bubble-dots-4' : '&#xe0d2;',
			'icon-bubble-13' : '&#xe0d3;',
			'icon-bubbles-9' : '&#xe0d4;',
			'icon-bubbles-10' : '&#xe0d5;',
			'icon-bubble-blocked' : '&#xe0d6;',
			'icon-bubble-quote' : '&#xe0d7;',
			'icon-bubble-user' : '&#xe0d8;',
			'icon-bubble-check' : '&#xe0d9;',
			'icon-bubble-video-chat' : '&#xe0da;',
			'icon-bubble-link' : '&#xe0db;',
			'icon-bubble-locked' : '&#xe0dc;',
			'icon-bubble-star' : '&#xe0dd;',
			'icon-bubble-heart' : '&#xe0de;',
			'icon-bubble-paperclip' : '&#xe0df;',
			'icon-bubble-cancel' : '&#xe0e0;',
			'icon-bubble-plus' : '&#xe0e1;',
			'icon-bubble-minus' : '&#xe0e2;',
			'icon-bubble-notification-2' : '&#xe0e3;',
			'icon-bubble-trash' : '&#xe0e4;',
			'icon-bubble-left' : '&#xe0e5;',
			'icon-user' : '&#xe0e6;',
			'icon-users' : '&#xe0e7;',
			'icon-user-plus' : '&#xe0e8;',
			'icon-user-plus-2' : '&#xe0e9;',
			'icon-user-minus' : '&#xe0ea;',
			'icon-user-minus-2' : '&#xe0eb;',
			'icon-user-2' : '&#xe0ec;',
			'icon-user-plus-3' : '&#xe0ed;',
			'icon-user-minus-3' : '&#xe0ee;',
			'icon-user-3' : '&#xe0ef;',
			'icon-users-2' : '&#xe0f0;',
			'icon-user-4' : '&#xe0f1;',
			'icon-vcard' : '&#xe0f2;',
			'icon-tshirt' : '&#xe0f3;',
			'icon-quotes-left' : '&#xe0f4;',
			'icon-quotes-right' : '&#xe0f5;',
			'icon-busy' : '&#xe0f6;',
			'icon-busy-2' : '&#xe0f7;',
			'icon-busy-3' : '&#xe0f8;',
			'icon-spinner' : '&#xe0f9;',
			'icon-binoculars' : '&#xe0fa;',
			'icon-binoculars-2' : '&#xe0fb;',
			'icon-search' : '&#xe0fc;',
			'icon-search-2' : '&#xe0fd;',
			'icon-zoom-in' : '&#xe0fe;',
			'icon-zoom-out' : '&#xe0ff;',
			'icon-search-3' : '&#xe100;',
			'icon-expand' : '&#xe101;',
			'icon-contract' : '&#xe102;',
			'icon-expand-2' : '&#xe103;',
			'icon-contract-2' : '&#xe104;',
			'icon-key' : '&#xe105;',
			'icon-key-2' : '&#xe106;',
			'icon-keyhole' : '&#xe107;',
			'icon-lock' : '&#xe108;',
			'icon-lock-2' : '&#xe109;',
			'icon-wrench' : '&#xe10a;',
			'icon-equalizer' : '&#xe10b;',
			'icon-equalizer-2' : '&#xe10c;',
			'icon-cog' : '&#xe10d;',
			'icon-cogs' : '&#xe10e;',
			'icon-cog-2' : '&#xe10f;',
			'icon-cog-3' : '&#xe110;',
			'icon-cog-4' : '&#xe111;',
			'icon-factory' : '&#xe112;',
			'icon-tools' : '&#xe113;',
			'icon-wand' : '&#xe114;',
			'icon-wand-2' : '&#xe115;',
			'icon-pie' : '&#xe116;',
			'icon-pie-2' : '&#xe117;',
			'icon-pie-3' : '&#xe118;',
			'icon-pie-4' : '&#xe119;',
			'icon-pie-5' : '&#xe11a;',
			'icon-pie-6' : '&#xe11b;',
			'icon-pie-7' : '&#xe11c;',
			'icon-stats' : '&#xe11d;',
			'icon-stats-2' : '&#xe11e;',
			'icon-stats-3' : '&#xe11f;',
			'icon-construction' : '&#xe120;',
			'icon-bug' : '&#xe121;',
			'icon-aid' : '&#xe122;',
			'icon-health' : '&#xe123;',
			'icon-bars' : '&#xe124;',
			'icon-bars-2' : '&#xe125;',
			'icon-bars-3' : '&#xe126;',
			'icon-bars-4' : '&#xe127;',
			'icon-bars-5' : '&#xe128;',
			'icon-stats-up' : '&#xe129;',
			'icon-stats-down' : '&#xe12a;',
			'icon-stairs-down' : '&#xe12b;',
			'icon-stairs-down-2' : '&#xe12c;',
			'icon-chart' : '&#xe12d;',
			'icon-gift' : '&#xe12e;',
			'icon-gift-2' : '&#xe12f;',
			'icon-trophy' : '&#xe130;',
			'icon-trophy-2' : '&#xe131;',
			'icon-trophy-star' : '&#xe132;',
			'icon-crown' : '&#xe133;',
			'icon-glass' : '&#xe134;',
			'icon-meter-slow' : '&#xe135;',
			'icon-meter' : '&#xe136;',
			'icon-lamp' : '&#xe137;',
			'icon-lamp-2' : '&#xe138;',
			'icon-magnet' : '&#xe139;',
			'icon-lab' : '&#xe13a;',
			'icon-lamp-3' : '&#xe13b;',
			'icon-lamp-4' : '&#xe13c;',
			'icon-remove' : '&#xe13d;',
			'icon-remove-2' : '&#xe13e;',
			'icon-remove-3' : '&#xe13f;',
			'icon-remove-4' : '&#xe140;',
			'icon-remove-5' : '&#xe141;',
			'icon-briefcase' : '&#xe142;',
			'icon-briefcase-2' : '&#xe143;',
			'icon-puzzle' : '&#xe144;',
			'icon-paper-plane' : '&#xe145;',
			'icon-bus' : '&#xe146;',
			'icon-truck' : '&#xe147;',
			'icon-cube' : '&#xe148;',
			'icon-cube4' : '&#xe149;',
			'icon-target' : '&#xe14a;',
			'icon-brain' : '&#xe14b;',
			'icon-accessibility' : '&#xe14c;',
			'icon-sun-glasses' : '&#xe14d;',
			'icon-target-2' : '&#xe14e;',
			'icon-shield' : '&#xe14f;',
			'icon-shield-2' : '&#xe150;',
			'icon-shield-3' : '&#xe151;',
			'icon-shield-4' : '&#xe152;',
			'icon-clipboard' : '&#xe153;',
			'icon-clipboard-2' : '&#xe154;',
			'icon-signup' : '&#xe155;',
			'icon-clipboard-3' : '&#xe156;',
			'icon-clipboard-4' : '&#xe157;',
			'icon-cord' : '&#xe158;',
			'icon-power-cord' : '&#xe159;',
			'icon-switch' : '&#xe15a;',
			'icon-power' : '&#xe15b;',
			'icon-list' : '&#xe15c;',
			'icon-list-2' : '&#xe15d;',
			'icon-list-3' : '&#xe15e;',
			'icon-numbered-list' : '&#xe15f;',
			'icon-list-4' : '&#xe160;',
			'icon-list-5' : '&#xe161;',
			'icon-playlist' : '&#xe162;',
			'icon-grid' : '&#xe163;',
			'icon-grid-2' : '&#xe164;',
			'icon-grid-3' : '&#xe165;',
			'icon-grid-4' : '&#xe166;',
			'icon-grid-5' : '&#xe167;',
			'icon-grid-6' : '&#xe168;',
			'icon-tree' : '&#xe169;',
			'icon-tree-2' : '&#xe16a;',
			'icon-tree-3' : '&#xe16b;',
			'icon-menu' : '&#xe16c;',
			'icon-menu-2' : '&#xe16d;',
			'icon-cloud-download' : '&#xe16e;',
			'icon-cloud-upload' : '&#xe16f;',
			'icon-download-2' : '&#xe170;',
			'icon-upload-2' : '&#xe171;',
			'icon-download-3' : '&#xe172;',
			'icon-upload-3' : '&#xe173;',
			'icon-download-4' : '&#xe174;',
			'icon-upload-4' : '&#xe175;',
			'icon-download-5' : '&#xe176;',
			'icon-upload-5' : '&#xe177;',
			'icon-earth' : '&#xe178;',
			'icon-network' : '&#xe179;',
			'icon-link' : '&#xe17a;',
			'icon-link-2' : '&#xe17b;',
			'icon-anchor' : '&#xe17c;',
			'icon-flag' : '&#xe17d;',
			'icon-flag-2' : '&#xe17e;',
			'icon-attachment' : '&#xe17f;',
			'icon-eye' : '&#xe180;',
			'icon-eye-blocked' : '&#xe181;',
			'icon-bookmarks' : '&#xe182;',
			'icon-bookmark' : '&#xe183;',
			'icon-brightness-contrast' : '&#xe184;',
			'icon-star' : '&#xe185;',
			'icon-star-2' : '&#xe186;',
			'icon-star-3' : '&#xe187;',
			'icon-star-4' : '&#xe188;',
			'icon-star-5' : '&#xe189;',
			'icon-star-6' : '&#xe18a;',
			'icon-heart' : '&#xe18b;',
			'icon-heart-2' : '&#xe18c;',
			'icon-heart-broken' : '&#xe18d;',
			'icon-thumbs-down' : '&#xe18e;',
			'icon-thumbs-down-2' : '&#xe18f;',
			'icon-thumbs-up' : '&#xe190;',
			'icon-thumbs-up-2' : '&#xe191;',
			'icon-thumbs-up-3' : '&#xe192;',
			'icon-thumbs-up-4' : '&#xe193;',
			'icon-happy' : '&#xe194;',
			'icon-happy-2' : '&#xe195;',
			'icon-smiley' : '&#xe196;',
			'icon-smiley-2' : '&#xe197;',
			'icon-tongue' : '&#xe198;',
			'icon-tongue-2' : '&#xe199;',
			'icon-sad' : '&#xe19a;',
			'icon-sad-2' : '&#xe19b;',
			'icon-wink' : '&#xe19c;',
			'icon-wink-2' : '&#xe19d;',
			'icon-grin' : '&#xe19e;',
			'icon-grin-2' : '&#xe19f;',
			'icon-cool' : '&#xe1a0;',
			'icon-cool-2' : '&#xe1a1;',
			'icon-angry' : '&#xe1a2;',
			'icon-angry-2' : '&#xe1a3;',
			'icon-evil' : '&#xe1a4;',
			'icon-evil-2' : '&#xe1a5;',
			'icon-confused' : '&#xe1a6;',
			'icon-confused-2' : '&#xe1a7;',
			'icon-cursor' : '&#xe1a8;',
			'icon-point-up' : '&#xe1a9;',
			'icon-point-right' : '&#xe1aa;',
			'icon-point-down' : '&#xe1ab;',
			'icon-point-left' : '&#xe1ac;',
			'icon-stack-empty' : '&#xe1ad;',
			'icon-stack-picture' : '&#xe1ae;',
			'icon-stack-list' : '&#xe1af;',
			'icon-stack-user' : '&#xe1b0;',
			'icon-move' : '&#xe1b1;',
			'icon-warning' : '&#xe1b2;',
			'icon-warning-2' : '&#xe1b3;',
			'icon-notification' : '&#xe1b6;',
			'icon-notification-2' : '&#xe1b7;',
			'icon-question' : '&#xe1b8;',
			'icon-question-2' : '&#xe1b9;',
			'icon-question-3' : '&#xe1ba;',
			'icon-question-4' : '&#xe1bb;',
			'icon-question-5' : '&#xe1bc;',
			'icon-plus-circle' : '&#xe1bd;',
			'icon-plus-circle-2' : '&#xe1be;',
			'icon-minus-circle' : '&#xe1bf;',
			'icon-minus-circle-2' : '&#xe1c0;',
			'icon-info' : '&#xe1c1;',
			'icon-info-2' : '&#xe1c2;',
			'icon-blocked' : '&#xe1c3;',
			'icon-cancel-circle' : '&#xe1c4;',
			'icon-cancel-circle-2' : '&#xe1c5;',
			'icon-cancel' : '&#xe1b4;',
			'icon-checkmark-circle' : '&#xe1b5;',
			'icon-checkmark-circle-2' : '&#xe1c6;',
			'icon-enter' : '&#xe1c7;',
			'icon-exit' : '&#xe1c8;',
			'icon-exit-2' : '&#xe1c9;',
			'icon-play-2' : '&#xe1ca;',
			'icon-pause' : '&#xe1cb;',
			'icon-stop' : '&#xe1cc;',
			'icon-backward' : '&#xe1cd;',
			'icon-forward-2' : '&#xe1ce;',
			'icon-play-3' : '&#xe1cf;',
			'icon-pause-2' : '&#xe1d0;',
			'icon-stop-2' : '&#xe1d1;',
			'icon-backward-2' : '&#xe1d2;',
			'icon-forward-3' : '&#xe1d3;',
			'icon-first' : '&#xe1d4;',
			'icon-last' : '&#xe1d5;',
			'icon-previous' : '&#xe1d6;',
			'icon-next' : '&#xe1d7;',
			'icon-eject' : '&#xe1d8;',
			'icon-volume-high' : '&#xe1d9;',
			'icon-spell-check' : '&#xe1da;',
			'icon-plus' : '&#xe1db;',
			'icon-checkmark' : '&#xe1dc;',
			'icon-checkmark-2' : '&#xe1dd;',
			'icon-close' : '&#xe1de;',
			'icon-arrow-up' : '&#xe1df;',
			'icon-arrow-right' : '&#xe1e0;',
			'icon-arrow-down' : '&#xe1e1;',
			'icon-arrow-left' : '&#xe1e2;',
			'icon-arrow-up-2' : '&#xe1e3;',
			'icon-arrow-right-2' : '&#xe1e4;',
			'icon-arrow-down-2' : '&#xe1e5;',
			'icon-arrow-left-2' : '&#xe1e6;',
			'icon-arrow-up-3' : '&#xe1e7;',
			'icon-arrow-right-3' : '&#xe1e8;',
			'icon-arrow-left-3' : '&#xe1e9;',
			'icon-arrow-up-4' : '&#xe1ea;',
			'icon-arrow-right-4' : '&#xe1eb;',
			'icon-arrow-left-4' : '&#xe1ec;',
			'icon-arrow-up-5' : '&#xe1ed;',
			'icon-arrow-right-5' : '&#xe1ee;',
			'icon-arrow-down-3' : '&#xe1ef;',
			'icon-arrow-left-5' : '&#xe1f0;',
			'icon-arrow-square' : '&#xe1f1;',
			'icon-arrow-right-6' : '&#xe1f2;',
			'icon-arrow-down-4' : '&#xe1f3;',
			'icon-arrow-left-6' : '&#xe1f4;',
			'icon-arrow-up-6' : '&#xe1f5;',
			'icon-arrow-right-7' : '&#xe1f6;',
			'icon-arrow-down-5' : '&#xe1f7;',
			'icon-arrow-left-7' : '&#xe1f8;',
			'icon-menu-3' : '&#xe1f9;',
			'icon-esc' : '&#xe1fa;',
			'icon-backspace' : '&#xe1fb;',
			'icon-checkbox-partial' : '&#xe1fc;',
			'icon-checkbox-checked' : '&#xe1fd;',
			'icon-checkbox' : '&#xe1fe;',
			'icon-radio-unchecked' : '&#xe1ff;',
			'icon-checkbox-unchecked' : '&#xe200;',
			'icon-filter' : '&#xe201;',
			'icon-font' : '&#xe202;',
			'icon-font-size' : '&#xe203;',
			'icon-type' : '&#xe204;',
			'icon-scissors' : '&#xe205;',
			'icon-vector' : '&#xe206;',
			'icon-scissors-2' : '&#xe207;',
			'icon-paragraph-justify' : '&#xe208;',
			'icon-table' : '&#xe209;',
			'icon-table-2' : '&#xe20a;',
			'icon-mail' : '&#xe20b;',
			'icon-google-plus' : '&#xe20d;',
			'icon-google-plus-2' : '&#xe20e;',
			'icon-google-plus-3' : '&#xe20f;',
			'icon-google-plus-4' : '&#xe210;',
			'icon-facebook' : '&#xe212;',
			'icon-facebook-2' : '&#xe213;',
			'icon-flickr' : '&#xe20c;',
			'icon-flickr-2' : '&#xe211;',
			'icon-vimeo' : '&#xe214;',
			'icon-vimeo2' : '&#xe215;',
			'icon-vimeo-2' : '&#xe216;',
			'icon-feed' : '&#xe217;',
			'icon-feed-2' : '&#xe218;',
			'icon-feed-3' : '&#xe219;',
			'icon-twitter' : '&#xe21a;',
			'icon-twitter-2' : '&#xe21b;',
			'icon-twitter-3' : '&#xe21c;',
			'icon-instagram' : '&#xe21d;',
			'icon-facebook-3' : '&#xe21e;',
			'icon-facebook-4' : '&#xe21f;',
			'icon-picassa' : '&#xe220;',
			'icon-picassa-2' : '&#xe221;',
			'icon-dribbble' : '&#xe222;',
			'icon-dribbble-2' : '&#xe223;',
			'icon-forrst' : '&#xe224;',
			'icon-forrst-2' : '&#xe225;',
			'icon-deviantart' : '&#xe226;',
			'icon-deviantart-2' : '&#xe227;',
			'icon-github' : '&#xe228;',
			'icon-blogger' : '&#xe229;',
			'icon-tumblr' : '&#xe22a;',
			'icon-windows' : '&#xe22b;',
			'icon-android' : '&#xe22c;',
			'icon-windows8' : '&#xe22d;',
			'icon-skype' : '&#xe22e;',
			'icon-lastfm' : '&#xe22f;',
			'icon-lastfm-2' : '&#xe230;',
			'icon-delicious' : '&#xe231;',
			'icon-stumbleupon' : '&#xe232;',
			'icon-stackoverflow' : '&#xe233;',
			'icon-pinterest' : '&#xe234;',
			'icon-pinterest-2' : '&#xe235;',
			'icon-paypal' : '&#xe236;',
			'icon-paypal-2' : '&#xe237;',
			'icon-libreoffice' : '&#xe238;',
			'icon-file-pdf' : '&#xe239;',
			'icon-file-openoffice' : '&#xe23a;',
			'icon-file-word' : '&#xe23b;',
			'icon-file-excel' : '&#xe23c;',
			'icon-yelp' : '&#xe23d;',
			'icon-safari' : '&#xe23e;',
			'icon-opera' : '&#xe23f;',
			'icon-IE' : '&#xe240;',
			'icon-firefox' : '&#xe241;',
			'icon-chrome' : '&#xe242;',
			'icon-html5' : '&#xe243;',
			'icon-html5-2' : '&#xe244;',
			'icon-file-css' : '&#xe245;',
			'icon-file-xml' : '&#xe246;',
			'icon-file-powerpoint' : '&#xe247;',
			'icon-file-zip' : '&#xe248;',
			'icon-console' : '&#xe249;',
			'icon-code' : '&#xe24a;',
			'icon-embed' : '&#xe24b;',
			'icon-paragraph-justify-2' : '&#xe24c;',
			'icon-new-tab' : '&#xe24d;',
			'icon-new-tab-2' : '&#xe24e;',
			'icon-pilcrow' : '&#xe24f;',
			'icon-linkedin' : '&#xe250;',
			'icon-reddit' : '&#xe251;',
			'icon-weather-lightning' : '&#xe252;',
			'icon-link-3' : '&#xe253;',
			'icon-heart-3' : '&#xf004;',
			'icon-star-7' : '&#xf005;',
			'icon-star-empty' : '&#xf006;',
			'icon-user-5' : '&#xf007;',
			'icon-film-2' : '&#xf008;',
			'icon-th-large' : '&#xf009;',
			'icon-th' : '&#xf00a;',
			'icon-th-list' : '&#xf00b;',
			'icon-ok' : '&#xf00c;',
			'icon-remove-6' : '&#xf00d;',
			'icon-zoom-in-2' : '&#xf00e;',
			'icon-zoom-out-2' : '&#xf010;',
			'icon-off' : '&#xf011;',
			'icon-signal' : '&#xf012;',
			'icon-cog-5' : '&#xf013;',
			'icon-road' : '&#xf018;',
			'icon-download-alt' : '&#xf019;',
			'icon-download-6' : '&#xf01a;',
			'icon-upload-6' : '&#xf01b;',
			'icon-inbox' : '&#xf01c;',
			'icon-play-circle' : '&#xf01d;',
			'icon-repeat' : '&#xf01e;',
			'icon-refresh' : '&#xf021;',
			'icon-list-alt' : '&#xf022;',
			'icon-lock-3' : '&#xf023;',
			'icon-flag-3' : '&#xf024;',
			'icon-headphones-3' : '&#xf025;',
			'icon-volume-off' : '&#xf026;',
			'icon-volume-down' : '&#xf027;',
			'icon-volume-up' : '&#xf028;',
			'icon-book-2' : '&#xf02d;',
			'icon-bookmark-2' : '&#xf02e;',
			'icon-print-4' : '&#xf02f;',
			'icon-camera-5' : '&#xf030;',
			'icon-font-2' : '&#xf031;',
			'icon-bold' : '&#xf032;',
			'icon-italic' : '&#xf033;',
			'icon-text-height' : '&#xf034;',
			'icon-text-width' : '&#xf035;',
			'icon-align-left' : '&#xf036;',
			'icon-align-center' : '&#xf037;',
			'icon-align-right' : '&#xf038;',
			'icon-align-justify' : '&#xf039;',
			'icon-list-6' : '&#xf03a;',
			'icon-indent-left' : '&#xf03b;',
			'icon-map-marker' : '&#xf041;',
			'icon-adjust' : '&#xf042;',
			'icon-tint' : '&#xf043;',
			'icon-edit' : '&#xf044;',
			'icon-share' : '&#xf045;',
			'icon-check' : '&#xf046;',
			'icon-move-2' : '&#xf047;',
			'icon-step-backward' : '&#xf048;',
			'icon-fast-backward' : '&#xf049;',
			'icon-backward-3' : '&#xf04a;',
			'icon-play-4' : '&#xf04b;',
			'icon-pause-3' : '&#xf04c;',
			'icon-stop-3' : '&#xf04d;',
			'icon-forward-4' : '&#xf04e;',
			'icon-fast-forward' : '&#xf050;',
			'icon-plus-sign' : '&#xf055;',
			'icon-minus-sign' : '&#xf056;',
			'icon-remove-sign' : '&#xf057;',
			'icon-ok-sign' : '&#xf058;',
			'icon-question-sign' : '&#xf059;',
			'icon-info-sign' : '&#xf05a;',
			'icon-screenshot' : '&#xf05b;',
			'icon-remove-circle' : '&#xf05c;',
			'icon-ok-circle' : '&#xf05d;',
			'icon-ban-circle' : '&#xf05e;',
			'icon-arrow-left-8' : '&#xf060;',
			'icon-arrow-right-8' : '&#xf061;',
			'icon-arrow-up-7' : '&#xf062;',
			'icon-arrow-down-6' : '&#xf063;',
			'icon-share-alt' : '&#xf064;',
			'icon-asterisk' : '&#xf069;',
			'icon-exclamation-sign' : '&#xf06a;',
			'icon-gift-3' : '&#xf06b;',
			'icon-leaf' : '&#xf06c;',
			'icon-fire' : '&#xf06d;',
			'icon-eye-open' : '&#xf06e;',
			'icon-eye-close' : '&#xf070;',
			'icon-warning-sign' : '&#xf071;',
			'icon-plane' : '&#xf072;',
			'icon-calendar-6' : '&#xf073;',
			'icon-random' : '&#xf074;',
			'icon-comment' : '&#xf075;',
			'icon-magnet-2' : '&#xf076;',
			'icon-chevron-up' : '&#xf077;',
			'icon-chevron-down' : '&#xf078;',
			'icon-glass-2' : '&#xf000;',
			'icon-music-2' : '&#xf001;',
			'icon-search-4' : '&#xf002;',
			'icon-envelope' : '&#xf003;',
			'icon-trash' : '&#xf014;',
			'icon-home-3' : '&#xf015;',
			'icon-file-10' : '&#xf016;',
			'icon-time' : '&#xf017;',
			'icon-qrcode-2' : '&#xf029;',
			'icon-barcode-2' : '&#xf02a;',
			'icon-tag-3' : '&#xf02b;',
			'icon-tags-3' : '&#xf02c;',
			'icon-indent-right' : '&#xf03c;',
			'icon-facetime-video' : '&#xf03d;',
			'icon-picture' : '&#xf03e;',
			'icon-pencil-4' : '&#xf040;',
			'icon-step-forward' : '&#xf051;',
			'icon-eject-2' : '&#xf052;',
			'icon-chevron-left' : '&#xf053;',
			'icon-chevron-right' : '&#xf054;',
			'icon-resize-full' : '&#xf065;',
			'icon-resize-small' : '&#xf066;',
			'icon-plus-2' : '&#xf067;',
			'icon-minus' : '&#xf068;',
			'icon-comments' : '&#xf086;',
			'icon-thumbs-up-5' : '&#xf087;',
			'icon-thumbs-down-3' : '&#xf088;',
			'icon-star-half' : '&#xf089;',
			'icon-heart-empty' : '&#xf08a;',
			'icon-signout' : '&#xf08b;',
			'icon-linkedin-sign' : '&#xf08c;',
			'icon-facebook-5' : '&#xf09a;',
			'icon-github-2' : '&#xf09b;',
			'icon-unlock' : '&#xf09c;',
			'icon-credit-3' : '&#xf09d;',
			'icon-rss' : '&#xf09e;',
			'icon-hdd' : '&#xf0a0;',
			'icon-bullhorn-2' : '&#xf0a1;',
			'icon-tasks' : '&#xf0ae;',
			'icon-filter-2' : '&#xf0b0;',
			'icon-briefcase-3' : '&#xf0b1;',
			'icon-fullscreen' : '&#xf0b2;',
			'icon-group' : '&#xf0c0;',
			'icon-link-4' : '&#xf0c1;',
			'icon-cloud' : '&#xf0c2;',
			'icon-magic' : '&#xf0d0;',
			'icon-truck-2' : '&#xf0d1;',
			'icon-pinterest-3' : '&#xf0d2;',
			'icon-pinterest-sign' : '&#xf0d3;',
			'icon-google-plus-sign' : '&#xf0d4;',
			'icon-google-plus-5' : '&#xf0d5;',
			'icon-money' : '&#xf0d6;',
			'icon-dashboard' : '&#xf0e4;',
			'icon-comment-alt' : '&#xf0e5;',
			'icon-comments-alt' : '&#xf0e6;',
			'icon-bolt' : '&#xf0e7;',
			'icon-sitemap' : '&#xf0e8;',
			'icon-umbrella' : '&#xf0e9;',
			'icon-paste-4' : '&#xf0ea;',
			'icon-hospital' : '&#xf0f8;',
			'icon-ambulance' : '&#xf0f9;',
			'icon-medkit' : '&#xf0fa;',
			'icon-fighter-jet' : '&#xf0fb;',
			'icon-beer' : '&#xf0fc;',
			'icon-h-sign' : '&#xf0fd;',
			'icon-plus-sign-2' : '&#xf0fe;',
			'icon-retweet' : '&#xf079;',
			'icon-shopping-cart' : '&#xf07a;',
			'icon-folder-close' : '&#xf07b;',
			'icon-folder-open-3' : '&#xf07c;',
			'icon-resize-vertical' : '&#xf07d;',
			'icon-resize-horizontal' : '&#xf07e;',
			'icon-bar-chart' : '&#xf080;',
			'icon-twitter-sign' : '&#xf081;',
			'icon-facebook-sign' : '&#xf082;',
			'icon-camera-retro' : '&#xf083;',
			'icon-key-3' : '&#xf084;',
			'icon-cogs-2' : '&#xf085;',
			'icon-pushpin-2' : '&#xf08d;',
			'icon-external-link' : '&#xf08e;',
			'icon-signin' : '&#xf090;',
			'icon-trophy-3' : '&#xf091;',
			'icon-github-sign' : '&#xf092;',
			'icon-upload-alt' : '&#xf093;',
			'icon-lemon' : '&#xf094;',
			'icon-phone-2' : '&#xf095;',
			'icon-check-empty' : '&#xf096;',
			'icon-bookmark-empty' : '&#xf097;',
			'icon-phone-sign' : '&#xf098;',
			'icon-twitter-4' : '&#xf099;',
			'icon-bell-2' : '&#xf0a2;',
			'icon-certificate-2' : '&#xf0a3;',
			'icon-hand-right' : '&#xf0a4;',
			'icon-hand-left' : '&#xf0a5;',
			'icon-hand-up' : '&#xf0a6;',
			'icon-hand-down' : '&#xf0a7;',
			'icon-circle-arrow-left' : '&#xf0a8;',
			'icon-circle-arrow-right' : '&#xf0a9;',
			'icon-circle-arrow-up' : '&#xf0aa;',
			'icon-circle-arrow-down' : '&#xf0ab;',
			'icon-globe' : '&#xf0ac;',
			'icon-wrench-2' : '&#xf0ad;',
			'icon-beaker' : '&#xf0c3;',
			'icon-cut' : '&#xf0c4;',
			'icon-copy-5' : '&#xf0c5;',
			'icon-paper-clip' : '&#xf0c6;',
			'icon-save' : '&#xf0c7;',
			'icon-sign-blank' : '&#xf0c8;',
			'icon-reorder' : '&#xf0c9;',
			'icon-list-ul' : '&#xf0ca;',
			'icon-list-ol' : '&#xf0cb;',
			'icon-strikethrough' : '&#xf0cc;',
			'icon-underline' : '&#xf0cd;',
			'icon-table-3' : '&#xf0ce;',
			'icon-caret-down' : '&#xf0d7;',
			'icon-caret-up' : '&#xf0d8;',
			'icon-caret-left' : '&#xf0d9;',
			'icon-caret-right' : '&#xf0da;',
			'icon-columns' : '&#xf0db;',
			'icon-sort' : '&#xf0dc;',
			'icon-sort-down' : '&#xf0dd;',
			'icon-sort-up' : '&#xf0de;',
			'icon-envelope-alt' : '&#xf0e0;',
			'icon-linkedin-2' : '&#xf0e1;',
			'icon-undo-2' : '&#xf0e2;',
			'icon-legal' : '&#xf0e3;',
			'icon-lightbulb' : '&#xf0eb;',
			'icon-exchange' : '&#xf0ec;',
			'icon-cloud-download-2' : '&#xf0ed;',
			'icon-cloud-upload-2' : '&#xf0ee;',
			'icon-user-md' : '&#xf0f0;',
			'icon-stethoscope' : '&#xf0f1;',
			'icon-suitcase' : '&#xf0f2;',
			'icon-bell-alt' : '&#xf0f3;',
			'icon-coffee' : '&#xf0f4;',
			'icon-food' : '&#xf0f5;',
			'icon-file-alt' : '&#xf0f6;',
			'icon-building' : '&#xf0f7;',
			'icon-folder-close-alt' : '&#xf114;',
			'icon-folder-open-alt' : '&#xf115;',
			'icon-double-angle-left' : '&#xf100;',
			'icon-double-angle-right' : '&#xf101;',
			'icon-double-angle-up' : '&#xf102;',
			'icon-double-angle-down' : '&#xf103;',
			'icon-angle-left' : '&#xf104;',
			'icon-angle-right' : '&#xf105;',
			'icon-angle-up' : '&#xf106;',
			'icon-angle-down' : '&#xf107;',
			'icon-desktop' : '&#xf108;',
			'icon-laptop-2' : '&#xf109;',
			'icon-tablet-2' : '&#xf10a;',
			'icon-mobile-4' : '&#xf10b;',
			'icon-circle-blank' : '&#xf10c;',
			'icon-quote-left' : '&#xf10d;',
			'icon-quote-right' : '&#xf10e;',
			'icon-spinner-2' : '&#xf110;',
			'icon-circle' : '&#xf111;',
			'icon-reply-3' : '&#xf112;',
			'icon-github-alt' : '&#xf113;',
			'icon-pawn' : '&#xe254;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
};