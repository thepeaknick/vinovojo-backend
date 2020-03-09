webpackJsonp(["main"],{

/***/ "./src/$$_lazy_route_resource lazy recursive":
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./calendar/calendar.module": [
		"./src/app/calendar/calendar.module.ts",
		"calendar.module"
	],
	"./components/components.module": [
		"./src/app/components/components.module.ts",
		"components.module"
	],
	"./dashboard/dashboard.module": [
		"./src/app/dashboard/dashboard.module.ts",
		"dashboard.module"
	],
	"./events/events.module": [
		"./src/app/events/events.module.ts",
		"events.module",
		"common"
	],
	"./forms/forms.module": [
		"./src/app/forms/forms.module.ts",
		"forms.module"
	],
	"./login/login.module": [
		"./src/app/login/login.module.ts",
		"common",
		"login.module"
	],
	"./maps/maps.module": [
		"./src/app/maps/maps.module.ts",
		"maps.module"
	],
	"./pages/pages.module": [
		"./src/app/pages/pages.module.ts",
		"pages.module"
	],
	"./tables/tables.module": [
		"./src/app/tables/tables.module.ts",
		"tables.module"
	],
	"./timeline/timeline.module": [
		"./src/app/timeline/timeline.module.ts",
		"timeline.module"
	],
	"./userpage/user.module": [
		"./src/app/userpage/user.module.ts",
		"user.module"
	],
	"./users/users.module": [
		"./src/app/users/users.module.ts",
		"common",
		"users.module"
	],
	"./widgets/widgets.module": [
		"./src/app/widgets/widgets.module.ts",
		"widgets.module"
	],
	"./wine-path/wine-path.module": [
		"./src/app/wine-path/wine-path.module.ts",
		"wine-path.module",
		"common"
	],
	"./winery/winery.module": [
		"./src/app/winery/winery.module.ts",
		"common",
		"winery.module"
	],
	"./wines/wines.module": [
		"./src/app/wines/wines.module.ts",
		"common",
		"wines.module"
	]
};
function webpackAsyncContext(req) {
	var ids = map[req];
	if(!ids)
		return Promise.reject(new Error("Cannot find module '" + req + "'."));
	return Promise.all(ids.slice(1).map(__webpack_require__.e)).then(function() {
		return __webpack_require__(ids[0]);
	});
};
webpackAsyncContext.keys = function webpackAsyncContextKeys() {
	return Object.keys(map);
};
webpackAsyncContext.id = "./src/$$_lazy_route_resource lazy recursive";
module.exports = webpackAsyncContext;

/***/ }),

/***/ "./src/app/app.component.html":
/***/ (function(module, exports) {

module.exports = "\r\n<router-outlet></router-outlet>\r\n"

/***/ }),

/***/ "./src/app/app.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AppComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};

var AppComponent = /** @class */ (function () {
    function AppComponent(elRef) {
        this.elRef = elRef;
    }
    AppComponent.prototype.ngOnInit = function () {
        var body = document.getElementsByTagName('body')[0];
        var isWindows = navigator.platform.indexOf('Win') > -1 ? true : false;
        if (isWindows) {
            // if we are on windows OS we activate the perfectScrollbar function
            body.classList.add("perfect-scrollbar-on");
        }
        else {
            body.classList.add("perfect-scrollbar-off");
        }
        $.material.init();
    };
    AppComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'my-app',
            template: __webpack_require__("./src/app/app.component.html")
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_0__angular_core__["ElementRef"]])
    ], AppComponent);
    return AppComponent;
}());



/***/ }),

/***/ "./src/app/app.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AppModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_platform_browser__ = __webpack_require__("./node_modules/@angular/platform-browser/esm5/platform-browser.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_platform_browser_animations__ = __webpack_require__("./node_modules/@angular/platform-browser/esm5/animations.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__angular_http__ = __webpack_require__("./node_modules/@angular/http/esm5/http.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__app_component__ = __webpack_require__("./src/app/app.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__sidebar_sidebar_module__ = __webpack_require__("./src/app/sidebar/sidebar.module.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__shared_footer_footer_module__ = __webpack_require__("./src/app/shared/footer/footer.module.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__shared_navbar_navbar_module__ = __webpack_require__("./src/app/shared/navbar/navbar.module.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__layouts_admin_admin_layout_component__ = __webpack_require__("./src/app/layouts/admin/admin-layout.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__layouts_auth_auth_layout_component__ = __webpack_require__("./src/app/layouts/auth/auth-layout.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__app_routing__ = __webpack_require__("./src/app/app.routing.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__services_http_service__ = __webpack_require__("./src/app/services/http.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__services_localstorage_service__ = __webpack_require__("./src/app/services/localstorage.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15__services_endpoint_service__ = __webpack_require__("./src/app/services/endpoint.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_16__notifications_notifications_service__ = __webpack_require__("./src/app/notifications/notifications.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_17__angular_common_http__ = __webpack_require__("./node_modules/@angular/common/esm5/http.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_18__agm_core__ = __webpack_require__("./node_modules/@agm/core/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_19__auth_auth_guard_service__ = __webpack_require__("./src/app/auth/auth-guard.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_20__auth_auth_service__ = __webpack_require__("./src/app/auth/auth.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_21__angular_common__ = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};






















// import { DataTablesModule } from "angular-datatables";
var AppModule = /** @class */ (function () {
    function AppModule() {
    }
    AppModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [
                __WEBPACK_IMPORTED_MODULE_1__angular_platform_browser__["a" /* BrowserModule */],
                __WEBPACK_IMPORTED_MODULE_2__angular_platform_browser_animations__["a" /* BrowserAnimationsModule */],
                __WEBPACK_IMPORTED_MODULE_5__angular_forms__["e" /* FormsModule */],
                __WEBPACK_IMPORTED_MODULE_3__angular_router__["c" /* RouterModule */].forRoot(__WEBPACK_IMPORTED_MODULE_12__app_routing__["a" /* AppRoutes */]),
                __WEBPACK_IMPORTED_MODULE_4__angular_http__["c" /* HttpModule */],
                __WEBPACK_IMPORTED_MODULE_17__angular_common_http__["b" /* HttpClientModule */],
                __WEBPACK_IMPORTED_MODULE_7__sidebar_sidebar_module__["a" /* SidebarModule */],
                __WEBPACK_IMPORTED_MODULE_9__shared_navbar_navbar_module__["a" /* NavbarModule */],
                __WEBPACK_IMPORTED_MODULE_8__shared_footer_footer_module__["a" /* FooterModule */],
                // DataTablesModule,
                __WEBPACK_IMPORTED_MODULE_18__agm_core__["a" /* AgmCoreModule */].forRoot({
                    apiKey: "AIzaSyC-RpJTVJRs0GxeYnTz2baSNdYHSFaLsdw",
                    libraries: ["places"]
                }),
            ],
            declarations: [
                __WEBPACK_IMPORTED_MODULE_6__app_component__["a" /* AppComponent */],
                __WEBPACK_IMPORTED_MODULE_10__layouts_admin_admin_layout_component__["a" /* AdminLayoutComponent */],
                __WEBPACK_IMPORTED_MODULE_11__layouts_auth_auth_layout_component__["a" /* AuthLayoutComponent */]
            ],
            providers: [
                __WEBPACK_IMPORTED_MODULE_13__services_http_service__["a" /* HttpService */],
                __WEBPACK_IMPORTED_MODULE_14__services_localstorage_service__["a" /* LocalStorageService */],
                __WEBPACK_IMPORTED_MODULE_15__services_endpoint_service__["a" /* Constants */],
                __WEBPACK_IMPORTED_MODULE_16__notifications_notifications_service__["a" /* NotificationsService */],
                __WEBPACK_IMPORTED_MODULE_19__auth_auth_guard_service__["a" /* AuthGuardService */],
                __WEBPACK_IMPORTED_MODULE_20__auth_auth_service__["a" /* AuthService */],
                { provide: __WEBPACK_IMPORTED_MODULE_21__angular_common__["g" /* LocationStrategy */], useClass: __WEBPACK_IMPORTED_MODULE_21__angular_common__["d" /* HashLocationStrategy */] }
            ],
            bootstrap: [__WEBPACK_IMPORTED_MODULE_6__app_component__["a" /* AppComponent */]]
        })
    ], AppModule);
    return AppModule;
}());



/***/ }),

/***/ "./src/app/app.routing.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AppRoutes; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__layouts_admin_admin_layout_component__ = __webpack_require__("./src/app/layouts/admin/admin-layout.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__layouts_auth_auth_layout_component__ = __webpack_require__("./src/app/layouts/auth/auth-layout.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__auth_auth_guard_service__ = __webpack_require__("./src/app/auth/auth-guard.service.ts");



var AppRoutes = [
    {
        path: "",
        redirectTo: "dashboard",
        pathMatch: "full",
        canActivate: [__WEBPACK_IMPORTED_MODULE_2__auth_auth_guard_service__["a" /* AuthGuardService */]]
    },
    {
        path: "",
        component: __WEBPACK_IMPORTED_MODULE_0__layouts_admin_admin_layout_component__["a" /* AdminLayoutComponent */],
        children: [
            {
                path: "",
                loadChildren: "./dashboard/dashboard.module#DashboardModule",
                canActivate: [__WEBPACK_IMPORTED_MODULE_2__auth_auth_guard_service__["a" /* AuthGuardService */]]
            },
            {
                path: "components",
                loadChildren: "./components/components.module#ComponentsModule"
            },
            {
                path: "forms",
                loadChildren: "./forms/forms.module#Forms"
            },
            {
                path: "tables",
                loadChildren: "./tables/tables.module#TablesModule"
            },
            {
                path: "maps",
                loadChildren: "./maps/maps.module#MapsModule"
            },
            {
                path: "widgets",
                loadChildren: "./widgets/widgets.module#WidgetsModule"
            },
            {
                path: "calendar",
                loadChildren: "./calendar/calendar.module#CalendarModule"
            },
            {
                path: "",
                loadChildren: "./userpage/user.module#UserModule"
            },
            {
                path: "",
                loadChildren: "./timeline/timeline.module#TimelineModule"
            },
            {
                path: "users",
                loadChildren: "./users/users.module#UsersModule",
                canActivate: [__WEBPACK_IMPORTED_MODULE_2__auth_auth_guard_service__["a" /* AuthGuardService */]]
            },
            {
                path: "winery",
                loadChildren: "./winery/winery.module#WineryModule",
                canActivate: [__WEBPACK_IMPORTED_MODULE_2__auth_auth_guard_service__["a" /* AuthGuardService */]]
            },
            {
                path: "wines",
                loadChildren: "./wines/wines.module#WinesModule",
                canActivate: [__WEBPACK_IMPORTED_MODULE_2__auth_auth_guard_service__["a" /* AuthGuardService */]]
            },
            {
                path: "events",
                loadChildren: "./events/events.module#EventsModule",
                canActivate: [__WEBPACK_IMPORTED_MODULE_2__auth_auth_guard_service__["a" /* AuthGuardService */]]
            },
            {
                path: 'wine-paths',
                loadChildren: './wine-path/wine-path.module#WinePathModule',
                canActivate: [__WEBPACK_IMPORTED_MODULE_2__auth_auth_guard_service__["a" /* AuthGuardService */]]
            }
        ]
    },
    {
        path: "",
        component: __WEBPACK_IMPORTED_MODULE_1__layouts_auth_auth_layout_component__["a" /* AuthLayoutComponent */],
        children: [
            {
                path: "login",
                loadChildren: "./login/login.module#LoginModule"
            }
        ]
    },
    {
        path: "",
        component: __WEBPACK_IMPORTED_MODULE_1__layouts_auth_auth_layout_component__["a" /* AuthLayoutComponent */],
        children: [
            {
                path: "pages",
                loadChildren: "./pages/pages.module#PagesModule"
            }
        ]
    }
];


/***/ }),

/***/ "./src/app/auth/auth-guard.service.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AuthGuardService; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__auth_service__ = __webpack_require__("./src/app/auth/auth.service.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};



var AuthGuardService = /** @class */ (function () {
    function AuthGuardService(auth, router) {
        this.auth = auth;
        this.router = router;
    }
    AuthGuardService.prototype.canActivate = function () {
        if (!this.auth.isAuthenticated()) {
            this.router.navigate(['login']);
            return false;
        }
        return true;
    };
    AuthGuardService = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Injectable"])(),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_2__auth_service__["a" /* AuthService */], __WEBPACK_IMPORTED_MODULE_1__angular_router__["b" /* Router */]])
    ], AuthGuardService);
    return AuthGuardService;
}());



/***/ }),

/***/ "./src/app/auth/auth.service.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AuthService; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__services_localstorage_service__ = __webpack_require__("./src/app/services/localstorage.service.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};


var AuthService = /** @class */ (function () {
    function AuthService(ls) {
        this.ls = ls;
    }
    // ...
    AuthService.prototype.isAuthenticated = function () {
        var token = this.ls.get('token');
        var user = this.ls.get('user');
        if (token != null) {
            return true;
        }
        // Check whether the token is expired and return
        // true or false
        // return !this.jwtHelper.isTokenExpired(token);
        return false;
    };
    AuthService = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Injectable"])(),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__services_localstorage_service__["a" /* LocalStorageService */]])
    ], AuthService);
    return AuthService;
}());



/***/ }),

/***/ "./src/app/layouts/admin/admin-layout.component.html":
/***/ (function(module, exports) {

module.exports = "\r\n<div class=\"wrapper\">\r\n    <div class=\"sidebar\" data-active-color=\"white\" data-background-color=\"red\" data-image=\"../assets/img/sidebar-1.jpg\">\r\n        <!-- <div class=\"sidebar\" data-color=\"red\" data-image=\"\"> -->\r\n        <sidebar-cmp></sidebar-cmp>\r\n        <div class=\"sidebar-background\" style=\"background-image: url(assets/img/sidebar-1.jpg)\"></div>\r\n    </div>\r\n    <div class=\"main-panel\">\r\n        <navbar-cmp></navbar-cmp>\r\n        <router-outlet></router-outlet>\r\n        <div *ngIf=\"!isMap()\">\r\n            <footer-cmp></footer-cmp>\r\n        </div>\r\n    </div>\r\n</div>\r\n"

/***/ }),

/***/ "./src/app/layouts/admin/admin-layout.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AdminLayoutComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__md_md_module__ = __webpack_require__("./src/app/md/md.module.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_common__ = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};



var AdminLayoutComponent = /** @class */ (function () {
    function AdminLayoutComponent(location) {
        this.location = location;
    }
    AdminLayoutComponent.prototype.ngOnInit = function () {
        var isWindows = navigator.platform.indexOf('Win') > -1 ? true : false;
        if (isWindows) {
            // if we are on windows OS we activate the perfectScrollbar function
            var $main_panel = $('.main-panel');
            $main_panel.perfectScrollbar();
        }
        this.navItems = [
            { type: __WEBPACK_IMPORTED_MODULE_1__md_md_module__["a" /* NavItemType */].NavbarLeft, title: 'Dashboard', iconClass: 'fa fa-dashboard' },
            {
                type: __WEBPACK_IMPORTED_MODULE_1__md_md_module__["a" /* NavItemType */].NavbarRight,
                title: '',
                iconClass: 'fa fa-bell-o',
                numNotifications: 5,
                dropdownItems: [
                    { title: 'Notification 1' },
                    { title: 'Notification 2' },
                    { title: 'Notification 3' },
                    { title: 'Notification 4' },
                    { title: 'Another Notification' }
                ]
            },
            {
                type: __WEBPACK_IMPORTED_MODULE_1__md_md_module__["a" /* NavItemType */].NavbarRight,
                title: '',
                iconClass: 'fa fa-list',
                dropdownItems: [
                    { iconClass: "pe-7s-mail", title: 'Messages' },
                    { iconClass: "pe-7s-help1", title: 'Help Center' },
                    { iconClass: "pe-7s-tools", title: 'Settings' },
                    'separator',
                    { iconClass: "pe-7s-lock", title: 'Lock Screen' },
                    { iconClass: "pe-7s-close-circle", title: 'Log Out' }
                ]
            },
            { type: __WEBPACK_IMPORTED_MODULE_1__md_md_module__["a" /* NavItemType */].NavbarLeft, title: 'Search', iconClass: 'fa fa-search' },
            { type: __WEBPACK_IMPORTED_MODULE_1__md_md_module__["a" /* NavItemType */].NavbarLeft, title: 'Account' },
            {
                type: __WEBPACK_IMPORTED_MODULE_1__md_md_module__["a" /* NavItemType */].NavbarLeft,
                title: 'Dropdown',
                dropdownItems: [
                    { title: 'Action' },
                    { title: 'Another action' },
                    { title: 'Something' },
                    { title: 'Another action' },
                    { title: 'Something' },
                    'separator',
                    { title: 'Separated link' },
                ]
            },
            { type: __WEBPACK_IMPORTED_MODULE_1__md_md_module__["a" /* NavItemType */].NavbarLeft, title: 'Log out' }
        ];
    };
    AdminLayoutComponent.prototype.isMap = function () {
        // console.log(this.location.prepareExternalUrl(this.location.path()));
        if (this.location.prepareExternalUrl(this.location.path()) == '/maps/fullscreen') {
            return true;
        }
        else {
            return false;
        }
    };
    AdminLayoutComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'app-layout',
            template: __webpack_require__("./src/app/layouts/admin/admin-layout.component.html")
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_2__angular_common__["f" /* Location */]])
    ], AdminLayoutComponent);
    return AdminLayoutComponent;
}());



/***/ }),

/***/ "./src/app/layouts/auth/auth-layout.component.html":
/***/ (function(module, exports) {

module.exports = "\r\n  <router-outlet></router-outlet>\r\n"

/***/ }),

/***/ "./src/app/layouts/auth/auth-layout.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AuthLayoutComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};

var AuthLayoutComponent = /** @class */ (function () {
    function AuthLayoutComponent() {
    }
    AuthLayoutComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'app-layout',
            template: __webpack_require__("./src/app/layouts/auth/auth-layout.component.html")
        })
    ], AuthLayoutComponent);
    return AuthLayoutComponent;
}());



/***/ }),

/***/ "./src/app/md/md-table/md-table.component.html":
/***/ (function(module, exports) {

module.exports = "\r\n  <div class=\"content table-responsive\">\r\n    <table class=\"table\">\r\n      <tbody>\r\n          <tr *ngFor=\"let row of data.dataRows\">\r\n            <!-- <td *ngFor=\"let cell of row\">{{ cell }}</td> -->\r\n            <td>\r\n                <div class=\"flag\">\r\n                    <img src=\"../../../assets/img/flags/{{row[0]}}.png\" alt=\"\">\r\n                </div>\r\n            </td>\r\n            <td>\r\n                {{row[1]}}\r\n            </td>\r\n            <td class=\"text-right\">\r\n                {{row[2]}}\r\n            </td>\r\n            <td class=\"text-right\">\r\n                {{row[3]}}\r\n            </td>\r\n          </tr>\r\n      </tbody>\r\n    </table>\r\n\r\n  </div>\r\n"

/***/ }),

/***/ "./src/app/md/md-table/md-table.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MdTableComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};

var MdTableComponent = /** @class */ (function () {
    function MdTableComponent() {
    }
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"])(),
        __metadata("design:type", String)
    ], MdTableComponent.prototype, "title", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"])(),
        __metadata("design:type", String)
    ], MdTableComponent.prototype, "subtitle", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"])(),
        __metadata("design:type", String)
    ], MdTableComponent.prototype, "cardClass", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"])(),
        __metadata("design:type", Object)
    ], MdTableComponent.prototype, "data", void 0);
    MdTableComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'md-table',
            template: __webpack_require__("./src/app/md/md-table/md-table.component.html"),
            changeDetection: __WEBPACK_IMPORTED_MODULE_0__angular_core__["ChangeDetectionStrategy"].OnPush
        }),
        __metadata("design:paramtypes", [])
    ], MdTableComponent);
    return MdTableComponent;
}());



/***/ }),

/***/ "./src/app/md/md.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return NavItemType; });
/* unused harmony export LbdModule */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_common__ = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__md_table_md_table_component__ = __webpack_require__("./src/app/md/md-table/md-table.component.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};




var NavItemType;
(function (NavItemType) {
    NavItemType[NavItemType["Sidebar"] = 1] = "Sidebar";
    NavItemType[NavItemType["NavbarLeft"] = 2] = "NavbarLeft";
    NavItemType[NavItemType["NavbarRight"] = 3] = "NavbarRight"; // Right-aligned link on navbar in desktop mode, shown above sidebar items on collapsed sidebar in mobile mode
})(NavItemType || (NavItemType = {}));
var LbdModule = /** @class */ (function () {
    function LbdModule() {
    }
    LbdModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [
                __WEBPACK_IMPORTED_MODULE_1__angular_common__["b" /* CommonModule */],
                __WEBPACK_IMPORTED_MODULE_2__angular_router__["c" /* RouterModule */]
            ],
            declarations: [
                __WEBPACK_IMPORTED_MODULE_3__md_table_md_table_component__["a" /* MdTableComponent */]
            ],
            exports: [
                __WEBPACK_IMPORTED_MODULE_3__md_table_md_table_component__["a" /* MdTableComponent */],
            ]
        })
    ], LbdModule);
    return LbdModule;
}());



/***/ }),

/***/ "./src/app/notifications/notifications.service.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return NotificationsService; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};

var NotificationsService = /** @class */ (function () {
    function NotificationsService() {
    }
    NotificationsService.prototype.showNotification = function (msg, color, icon) {
        $.notify({
            icon: 'notifications',
            message: msg,
        }, {
            type: color,
            timer: 3000,
            placement: {
                from: 'bottom',
                align: 'right'
            }
        });
    };
    NotificationsService = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Injectable"])(),
        __metadata("design:paramtypes", [])
    ], NotificationsService);
    return NotificationsService;
}());



/***/ }),

/***/ "./src/app/services/endpoint.service.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return Constants; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};

var Constants = /** @class */ (function () {
    function Constants() {
        // public endpoint: string = 'http://oneview.misa.local/backend/public/api/';
        this.endpoint = 'http://81.4.110.135/vino/api/public/index.php/';
    }
    // public endpoint: string = 'http://172.16.40.42:8080/';
    Constants.prototype.url = function (route) {
        return this.endpoint + route;
    };
    Constants = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Injectable"])()
    ], Constants);
    return Constants;
}());



/***/ }),

/***/ "./src/app/services/http.service.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return HttpService; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__endpoint_service__ = __webpack_require__("./src/app/services/endpoint.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_http__ = __webpack_require__("./node_modules/@angular/http/esm5/http.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__localstorage_service__ = __webpack_require__("./src/app/services/localstorage.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__angular_common_http__ = __webpack_require__("./node_modules/@angular/common/esm5/http.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_rxjs_operators__ = __webpack_require__("./node_modules/rxjs/_esm5/operators.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};






var HttpService = /** @class */ (function () {
    function HttpService(endpoint, http, ls, httpc) {
        this.endpoint = endpoint;
        this.http = http;
        this.ls = ls;
        this.httpc = httpc;
    }
    HttpService.prototype.ngOnInit = function () {
    };
    HttpService.prototype.findEvents = function (route, lang, pageNumber) {
        var url = this.endpoint.url(route);
        return this.httpc.get(url, {
            params: new __WEBPACK_IMPORTED_MODULE_4__angular_common_http__["d" /* HttpParams */]()
                .set('page', pageNumber.toString()),
            headers: new __WEBPACK_IMPORTED_MODULE_4__angular_common_http__["c" /* HttpHeaders */]().set('Accept-Language', lang.toString())
        }).pipe(Object(__WEBPACK_IMPORTED_MODULE_5_rxjs_operators__["map"])(function (res) { return res['data']; }));
    };
    HttpService.prototype.findUser = function (route, pageNumber) {
        var url = this.endpoint.url(route);
        return this.httpc.get(url, {
            params: new __WEBPACK_IMPORTED_MODULE_4__angular_common_http__["d" /* HttpParams */]()
                .set('page', pageNumber.toString())
        }).pipe(Object(__WEBPACK_IMPORTED_MODULE_5_rxjs_operators__["map"])(function (res) { return res['data']; }));
    };
    HttpService.prototype.findWineries = function (route, lang, pageNumber) {
        var url = this.endpoint.url(route);
        return this.httpc.get(url, {
            params: new __WEBPACK_IMPORTED_MODULE_4__angular_common_http__["d" /* HttpParams */]()
                .set('page', pageNumber.toString()),
            headers: new __WEBPACK_IMPORTED_MODULE_4__angular_common_http__["c" /* HttpHeaders */]().set('Accept-Language', lang.toString())
        }).pipe(Object(__WEBPACK_IMPORTED_MODULE_5_rxjs_operators__["map"])(function (res) { return res['data']; }));
    };
    HttpService.prototype.findWines = function (route, lang, pageNumber) {
        if (pageNumber === void 0) { pageNumber = 1; }
        var url = this.endpoint.url(route);
        return this.httpc.get(url, {
            params: new __WEBPACK_IMPORTED_MODULE_4__angular_common_http__["d" /* HttpParams */]()
                .set('page', pageNumber.toString()),
            headers: new __WEBPACK_IMPORTED_MODULE_4__angular_common_http__["c" /* HttpHeaders */]().set('Accept-Language', lang.toString())
        }).pipe(Object(__WEBPACK_IMPORTED_MODULE_5_rxjs_operators__["map"])(function (res) { return res['data']; }));
    };
    HttpService.prototype.get = function (route, lang, token) {
        if (token === void 0) { token = true; }
        var url = this.endpoint.url(route);
        var headers = new __WEBPACK_IMPORTED_MODULE_2__angular_http__["a" /* Headers */]();
        if (token) {
            headers.append('Authorization', 'Bearer ' + this.ls.get('token'));
        }
        headers.append('Accept-Language', lang);
        headers.append('Accept', 'application/json');
        var options = new __WEBPACK_IMPORTED_MODULE_2__angular_http__["d" /* RequestOptions */]({ headers: headers });
        var o = this.http.get(url, options);
        // o.connect();
        return o;
    };
    HttpService.prototype.post = function (route, data, token) {
        if (token === void 0) { token = true; }
        var url = this.endpoint.url(route);
        var headers = new __WEBPACK_IMPORTED_MODULE_2__angular_http__["a" /* Headers */]();
        if (token) {
            headers.append('Authorization', 'Bearer ' + this.ls.get('token'));
        }
        headers.append('Accept', 'application/json');
        headers.append('Content-Type', 'application/json');
        data = JSON.stringify(data);
        var options = new __WEBPACK_IMPORTED_MODULE_2__angular_http__["d" /* RequestOptions */]({ headers: headers });
        return this.http.post(url, data, options);
    };
    HttpService.prototype.patch = function (route, data, token) {
        if (token === void 0) { token = true; }
        var url = this.endpoint.url(route);
        var headers = new __WEBPACK_IMPORTED_MODULE_2__angular_http__["a" /* Headers */]();
        if (token) {
            headers.append('Authorization', 'Bearer ' + this.ls.get('token'));
        }
        headers.append('Accept', 'application/json');
        headers.append('Content-Type', 'application/json');
        data = JSON.stringify(data);
        var options = new __WEBPACK_IMPORTED_MODULE_2__angular_http__["d" /* RequestOptions */]({ headers: headers });
        return this.http.patch(url, data, options);
    };
    HttpService.prototype.patchFile = function (route, data, token) {
        if (token === void 0) { token = true; }
        var url = this.endpoint.url(route);
        var headers = new __WEBPACK_IMPORTED_MODULE_2__angular_http__["a" /* Headers */]();
        if (token) {
            headers.append('Authorization', 'Bearer ' + this.ls.get('token'));
        }
        var options = new __WEBPACK_IMPORTED_MODULE_2__angular_http__["d" /* RequestOptions */]({ headers: headers });
        return this.http.patch(url, data, options);
    };
    HttpService.prototype.postFormData = function (route, data, token, lang) {
        if (token === void 0) { token = true; }
        var url = this.endpoint.url(route);
        var headers = new __WEBPACK_IMPORTED_MODULE_2__angular_http__["a" /* Headers */]();
        if (token) {
            headers.append('Authorization', 'Bearer ' + this.ls.get('token'));
        }
        if (lang) {
            headers.append('Accept-Language', lang.toString());
        }
        var options = new __WEBPACK_IMPORTED_MODULE_2__angular_http__["d" /* RequestOptions */]({ headers: headers });
        return this.http.post(url, data, options);
    };
    HttpService.prototype.download = function (url, token) {
        if (token === void 0) { token = true; }
    };
    HttpService.prototype.delete = function (route, token) {
        if (token === void 0) { token = true; }
        var url = this.endpoint.url(route);
        var headers = new __WEBPACK_IMPORTED_MODULE_4__angular_common_http__["c" /* HttpHeaders */]();
        if (token) {
            headers = headers.set('Authorization', 'Bearer ' + this.ls.get('token'));
        }
        return this.httpc.delete(url, { observe: 'response', headers: headers });
    };
    HttpService.prototype.upload = function (url, file, fileName, postData, token) {
        if (postData === void 0) { postData = null; }
        if (token === void 0) { token = true; }
        url = this.endpoint.url(url);
        var form = new FormData();
        form.append(fileName, file);
        console.log(typeof postData);
        if (typeof postData == 'object')
            for (var key in postData)
                form.append(key, postData[key]);
        var headers = new __WEBPACK_IMPORTED_MODULE_2__angular_http__["a" /* Headers */]();
        if (token) {
            headers.append('Authorization', 'Bearer ' + this.ls.get('token'));
        }
        headers.append('Accept', 'application/json');
        var options = new __WEBPACK_IMPORTED_MODULE_2__angular_http__["d" /* RequestOptions */]({ headers: headers });
        return this.http.post(url, form, options); // salje prazan payload
    };
    HttpService = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Injectable"])(),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__endpoint_service__["a" /* Constants */],
            __WEBPACK_IMPORTED_MODULE_2__angular_http__["b" /* Http */],
            __WEBPACK_IMPORTED_MODULE_3__localstorage_service__["a" /* LocalStorageService */],
            __WEBPACK_IMPORTED_MODULE_4__angular_common_http__["a" /* HttpClient */]])
    ], HttpService);
    return HttpService;
}());



/***/ }),

/***/ "./src/app/services/localstorage.service.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return LocalStorageService; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};

var LocalStorageService = /** @class */ (function () {
    function LocalStorageService() {
    }
    LocalStorageService.prototype.ngOnInit = function () {
    };
    LocalStorageService.prototype.has = function (name) {
        return this.get(name) != null;
    };
    LocalStorageService.prototype.get = function (name) {
        var string = localStorage.getItem(name);
        if (string == null)
            return null;
        return JSON.parse(string);
    };
    LocalStorageService.prototype.remove = function (name) {
        localStorage.removeItem(name);
    };
    LocalStorageService.prototype.set = function (name, value) {
        value = JSON.stringify(value);
        localStorage.setItem(name, value);
    };
    LocalStorageService = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Injectable"])(),
        __metadata("design:paramtypes", [])
    ], LocalStorageService);
    return LocalStorageService;
}());



/***/ }),

/***/ "./src/app/shared/footer/footer.component.html":
/***/ (function(module, exports) {

module.exports = "<footer class=\"footer\">\r\n    <div class=\"container-fluid\">\r\n        <!-- <nav class=\"pull-left\">\r\n            <ul>\r\n                <li>\r\n                    <a href=\"#\">\r\n                        Home\r\n                    </a>\r\n                </li>\r\n                <li>\r\n                    <a href=\"#\">\r\n                        Company\r\n                    </a>\r\n                </li>\r\n                <li>\r\n                    <a href=\"#\">\r\n                        Portfolio\r\n                    </a>\r\n                </li>\r\n                <li>\r\n                    <a href=\"#\">\r\n                        Blog\r\n                    </a>\r\n                </li>\r\n            </ul>\r\n        </nav> -->\r\n        <p class=\"copyright pull-right\">\r\n            &copy; {{test | date: 'yyyy'}}\r\n            <!-- <a href=\"https://www.creative-tim.com\">Creative Tim</a>, made with love for a better web -->\r\n        </p>\r\n    </div>\r\n</footer>"

/***/ }),

/***/ "./src/app/shared/footer/footer.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return FooterComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};

var FooterComponent = /** @class */ (function () {
    function FooterComponent() {
        this.test = new Date();
    }
    FooterComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            moduleId: module.i,
            selector: 'footer-cmp',
            template: __webpack_require__("./src/app/shared/footer/footer.component.html")
        })
    ], FooterComponent);
    return FooterComponent;
}());



/***/ }),

/***/ "./src/app/shared/footer/footer.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return FooterModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_common__ = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__footer_component__ = __webpack_require__("./src/app/shared/footer/footer.component.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};




var FooterModule = /** @class */ (function () {
    function FooterModule() {
    }
    FooterModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [__WEBPACK_IMPORTED_MODULE_2__angular_router__["c" /* RouterModule */], __WEBPACK_IMPORTED_MODULE_1__angular_common__["b" /* CommonModule */]],
            declarations: [__WEBPACK_IMPORTED_MODULE_3__footer_component__["a" /* FooterComponent */]],
            exports: [__WEBPACK_IMPORTED_MODULE_3__footer_component__["a" /* FooterComponent */]]
        })
    ], FooterModule);
    return FooterModule;
}());



/***/ }),

/***/ "./src/app/shared/navbar/navbar.component.css":
/***/ (function(module, exports) {

module.exports = "li.dropdown {\r\n    cursor: pointer;\r\n}"

/***/ }),

/***/ "./src/app/shared/navbar/navbar.component.html":
/***/ (function(module, exports) {

module.exports = "<nav class=\"navbar navbar-transparent navbar-absolute\">\r\n    <div class=\"container-fluid\">\r\n        <div class=\"navbar-minimize\">\r\n            <button id=\"minimizeSidebar\" class=\"btn btn-round btn-white btn-fill btn-just-icon\">\r\n                <i class=\"material-icons visible-on-sidebar-regular\">more_vert</i>\r\n                <i class=\"material-icons visible-on-sidebar-mini\">view_list</i>\r\n            </button>\r\n        </div>\r\n        <div class=\"navbar-header\">\r\n            <button type=\"button\" class=\"navbar-toggle\" (click)=\"sidebarToggle()\">\r\n                <span class=\"sr-only\">Toggle navigation</span>\r\n                <span class=\"icon-bar\"></span>\r\n                <span class=\"icon-bar\"></span>\r\n                <span class=\"icon-bar\"></span>\r\n            </button>\r\n            <a class=\"navbar-brand\" href=\"{{getPath()}}\"> {{getTitle()}} </a>\r\n        </div>\r\n        <div class=\"collapse navbar-collapse\">\r\n            <div *ngIf=\"isMobileMenu()\">\r\n                <ul class=\"nav navbar-nav navbar-right\">\r\n                    <li class='dropdown'>\r\n                        <a (click)=\"home()\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">\r\n                            <i class=\"material-icons\">dashboard</i>\r\n                            <p class=\"hidden-lg hidden-md\">Kontrolna tabla</p>\r\n                        </a>\r\n                    </li>\r\n                    <!-- <li class=\"dropdown\">\r\n                        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">\r\n                            <i class=\"material-icons\">notifications</i>\r\n                            <span class=\"notification\">5</span>\r\n                            <p class=\"hidden-lg hidden-md\">\r\n                                Notifications\r\n                                <b class=\"caret\"></b>\r\n                            </p>\r\n                        </a>\r\n                        <ul class=\"dropdown-menu\">\r\n                            <li>\r\n                                <a href=\"#\">Mike John responded to your email</a>\r\n                            </li>\r\n                            <li>\r\n                                <a href=\"#\">You have 5 new tasks</a>\r\n                            </li>\r\n                            <li>\r\n                                <a href=\"#\">You're now friend with Andrew</a>\r\n                            </li>\r\n                            <li>\r\n                                <a href=\"#\">Another Notification</a>\r\n                            </li>\r\n                            <li>\r\n                                <a href=\"#\">Another One</a>\r\n                            </li>\r\n                        </ul>\r\n                    </li> -->\r\n                    <li class=\"dropdown\">\r\n                        <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" aria-expanded=\"false\">\r\n                            <i class=\"material-icons\">person</i>\r\n                            <p class=\"hidden-lg hidden-md\">Profil</p>\r\n                            <div class=\"ripple-container\"></div>\r\n                        </a>\r\n                        <ul class=\"dropdown-menu\">\r\n                            <li>\r\n                                <a (click)=\"onEditLoggedUser()\">Korisnička podešavanja</a>\r\n                            </li>\r\n                            <li>\r\n                                <a (click)=\"onLogout()\">Odjavi se</a>\r\n                            </li>\r\n                        </ul>\r\n                    </li>\r\n                    <li class=\"separator hidden-lg hidden-md\"></li>\r\n                </ul>\r\n                <!-- <form class=\"navbar-form navbar-right\" role=\"search\">\r\n                    <div class=\"form-group form-search is-empty\">\r\n                        <input type=\"text\" class=\"form-control\" placeholder=\"Search\">\r\n                        <span class=\"material-input\"></span>\r\n                    </div>\r\n                    <button type=\"submit\" class=\"btn btn-white btn-round btn-just-icon\">\r\n                        <i class=\"material-icons\">search</i>\r\n                        <div class=\"ripple-container\"></div>\r\n                    </button>\r\n                </form> -->\r\n            </div>\r\n        </div>\r\n    </div>\r\n</nav>"

/***/ }),

/***/ "./src/app/shared/navbar/navbar.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return NavbarComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__sidebar_sidebar_routes_config__ = __webpack_require__("./src/app/sidebar/sidebar-routes.config.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__angular_common__ = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__services_localstorage_service__ = __webpack_require__("./src/app/services/localstorage.service.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





var misc = {
    navbar_menu_visible: 0,
    active_collapse: true,
    disabled_collapse_init: 0,
};
var NavbarComponent = /** @class */ (function () {
    function NavbarComponent(location, renderer, element, router, ls) {
        this.renderer = renderer;
        this.element = element;
        this.router = router;
        this.ls = ls;
        this.location = location;
        this.nativeElement = element.nativeElement;
        this.sidebarVisible = false;
    }
    NavbarComponent.prototype.ngOnInit = function () {
        this.listTitles = __WEBPACK_IMPORTED_MODULE_1__sidebar_sidebar_routes_config__["a" /* ROUTES */].filter(function (listTitle) { return listTitle; });
        var navbar = this.element.nativeElement;
        this.toggleButton = navbar.getElementsByClassName('navbar-toggle')[0];
        if ($('body').hasClass('sidebar-mini')) {
            misc.sidebar_mini_active = true;
        }
        $('#minimizeSidebar').click(function () {
            var $btn = $(this);
            if (misc.sidebar_mini_active == true) {
                $('body').removeClass('sidebar-mini');
                misc.sidebar_mini_active = false;
            }
            else {
                setTimeout(function () {
                    $('body').addClass('sidebar-mini');
                    misc.sidebar_mini_active = true;
                }, 300);
            }
            // we simulate the window Resize so the charts will get updated in realtime.
            var simulateWindowResize = setInterval(function () {
                window.dispatchEvent(new Event('resize'));
            }, 180);
            // we stop the simulation of Window Resize after the animations are completed
            setTimeout(function () {
                clearInterval(simulateWindowResize);
            }, 1000);
        });
    };
    NavbarComponent.prototype.home = function () {
        this.router.navigate(['/dashboard']);
    };
    NavbarComponent.prototype.onLogout = function () {
        this.ls.remove('token');
        this.ls.remove('user');
        this.router.navigate(['login']);
    };
    NavbarComponent.prototype.onEditLoggedUser = function () {
        var id = this.ls.get('user_id');
        this.router.navigate(['users/edit/' + id]);
    };
    NavbarComponent.prototype.isMobileMenu = function () {
        if ($(window).width() < 991) {
            return false;
        }
        return true;
    };
    NavbarComponent.prototype.sidebarToggle = function () {
        var toggleButton = this.toggleButton;
        var body = document.getElementsByTagName('body')[0];
        if (this.sidebarVisible == false) {
            setTimeout(function () {
                toggleButton.classList.add('toggled');
            }, 500);
            body.classList.add('nav-open');
            this.sidebarVisible = true;
        }
        else {
            this.toggleButton.classList.remove('toggled');
            this.sidebarVisible = false;
            body.classList.remove('nav-open');
        }
    };
    NavbarComponent.prototype.getTitle = function () {
        var titlee = this.location.prepareExternalUrl(this.location.path());
        if (titlee.charAt(0) === '#') {
            titlee = titlee.slice(2);
        }
        for (var item = 0; item < this.listTitles.length; item++) {
            if (this.listTitles[item].path === titlee) {
                return this.listTitles[item].title;
            }
        }
        return '';
    };
    NavbarComponent.prototype.getPath = function () {
        // console.log(this.location);
        return this.location.prepareExternalUrl(this.location.path());
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])("navbar-cmp"),
        __metadata("design:type", Object)
    ], NavbarComponent.prototype, "button", void 0);
    NavbarComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            moduleId: module.i,
            selector: 'navbar-cmp',
            template: __webpack_require__("./src/app/shared/navbar/navbar.component.html"),
            styles: [__webpack_require__("./src/app/shared/navbar/navbar.component.css")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_3__angular_common__["f" /* Location */], __WEBPACK_IMPORTED_MODULE_0__angular_core__["Renderer"], __WEBPACK_IMPORTED_MODULE_0__angular_core__["ElementRef"], __WEBPACK_IMPORTED_MODULE_2__angular_router__["b" /* Router */], __WEBPACK_IMPORTED_MODULE_4__services_localstorage_service__["a" /* LocalStorageService */]])
    ], NavbarComponent);
    return NavbarComponent;
}());



/***/ }),

/***/ "./src/app/shared/navbar/navbar.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return NavbarModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_common__ = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__navbar_component__ = __webpack_require__("./src/app/shared/navbar/navbar.component.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};




var NavbarModule = /** @class */ (function () {
    function NavbarModule() {
    }
    NavbarModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [__WEBPACK_IMPORTED_MODULE_2__angular_router__["c" /* RouterModule */], __WEBPACK_IMPORTED_MODULE_1__angular_common__["b" /* CommonModule */]],
            declarations: [__WEBPACK_IMPORTED_MODULE_3__navbar_component__["a" /* NavbarComponent */]],
            exports: [__WEBPACK_IMPORTED_MODULE_3__navbar_component__["a" /* NavbarComponent */]]
        })
    ], NavbarModule);
    return NavbarModule;
}());



/***/ }),

/***/ "./src/app/sidebar/sidebar-routes.config.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ROUTES; });
var ROUTES = [
    { path: '/dashboard', title: 'Kontrolna tabla', icon: 'material-icons' },
    { path: '/users', title: 'Korisnici', icon: 'material-icons' },
    { path: '/winery', title: 'Vinarije', icon: 'material-icons' },
    { path: '/wines', title: 'Vina', icon: 'material-icons' },
    { path: '/events', title: 'Dešavanja', icon: 'material-icons' },
    { path: '/wine-paths', title: 'Wine paths', icon: 'material-icons' },
    { path: '/dashboard', title: 'Map', icon: 'material-icons' },
    { path: '/dashboard', title: 'News', icon: 'material-icons' },
    { path: '/dashboard', title: 'Comments', icon: 'material-icons' },
    { path: '/dashboard', title: 'Push notifications', icon: 'material-icons' },
    { path: '/dashboard', title: 'Settings', icon: 'material-icons' },
];


/***/ }),

/***/ "./src/app/sidebar/sidebar.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"logo\">\r\n    <div class=\"logo-normal\">\r\n        <a href=\"#\" class=\"simple-text\">\r\n                   Vino Vojo\r\n                </a>\r\n    </div>\r\n\r\n    <div class=\"logo-img\">\r\n        <img src=\"./assets/img/vinovojologo.png\" />\r\n    </div>\r\n</div>\r\n\r\n\r\n<div class=\"sidebar-wrapper\">\r\n\r\n    <div class=\"user\">\r\n        <div class=\"photo\">\r\n            <img src=\"./assets/img/default_avatar.png\" />\r\n        </div>\r\n        <div class=\"info\">\r\n            <a data-toggle=\"collapse\" href=\"#collapseExample\" class=\"collapsed\">\r\n                <span>\r\n                            {{user}}\r\n                            <b class=\"caret\"></b>\r\n                        </span>\r\n            </a>\r\n            <div class=\"collapse\" id=\"collapseExample\">\r\n                <ul class=\"nav\">\r\n                    <!-- <li>\r\n                        <a href=\"javascript:void(0)\">\r\n                            <span class=\"sidebar-mini\">MP</span>\r\n                            <span class=\"sidebar-normal\">My Profile</span>\r\n                        </a>\r\n                    </li>\r\n                    <li>\r\n                        <a href=\"javascript:void(0)\">\r\n                            <span class=\"sidebar-mini\">EP</span>\r\n                            <span class=\"sidebar-normal\">Edit Profile</span>\r\n                        </a>\r\n                    </li> -->\r\n                    <li>\r\n                        <a href=\"javascript:void(0)\">\r\n                            <span class=\"sidebar-mini\">S</span>\r\n                            <span class=\"sidebar-normal\" (click)=\"onEditLoggedUser()\">Korisnička podešavanja</span>\r\n                        </a>\r\n                    </li>\r\n                    <li>\r\n                        <a href=\"javascript:void(0)\">\r\n                            <span class=\"sidebar-mini\">L</span>\r\n                            <span class=\"sidebar-normal\" (click)=\"onLogout()\">Odjavi se</span>\r\n                        </a>\r\n                    </li>\r\n                </ul>\r\n            </div>\r\n        </div>\r\n    </div>\r\n    <div *ngIf=\"isNotMobileMenu()\">\r\n        <form class=\"navbar-form navbar-right\" role=\"search\">\r\n            <div class=\"form-group form-search is-empty\">\r\n                <input class=\"form-control\" placeholder=\"Search\" type=\"text\">\r\n                <span class=\"material-input\"></span>\r\n                <span class=\"material-input\"></span>\r\n            </div>\r\n            <button class=\"btn btn-white btn-round btn-just-icon\" type=\"submit\">\r\n                        <i class=\"material-icons\">search</i>\r\n                        <div class=\"ripple-container\"></div>\r\n                    </button>\r\n        </form>\r\n        <ul class=\"nav nav-mobile-menu\">\r\n            <!-- <li class=\"dropdown\">\r\n                <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" aria-expanded=\"false\">\r\n                    <i class=\"material-icons\">dashboard</i>\r\n                    <p class=\"hidden-lg hidden-md\">Dashboard</p>\r\n                    <div class=\"ripple-container\"></div>\r\n                </a>\r\n            </li> -->\r\n            <!-- <li class=\"dropdown\">\r\n                <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" aria-expanded=\"false\">\r\n                    <i class=\"material-icons\">notifications</i>\r\n                    <span class=\"notification\">5</span>\r\n                    <p class=\"hidden-lg hidden-md\">\r\n                        Notifications\r\n                        <b class=\"caret\"></b>\r\n                    </p>\r\n                    <div class=\"ripple-container\"></div>\r\n                </a>\r\n                <ul class=\"dropdown-menu\">\r\n                    <li>\r\n                        <a href=\"#\">Mike John responded to your email</a>\r\n                    </li>\r\n                    <li>\r\n                        <a href=\"#\">You have 5 new tasks</a>\r\n                    </li>\r\n                    <li>\r\n                        <a href=\"#\">You're now friend with Andrew</a>\r\n                    </li>\r\n                    <li>\r\n                        <a href=\"#\">Another Notification</a>\r\n                    </li>\r\n                    <li>\r\n                        <a href=\"#\">Another One</a>\r\n                    </li>\r\n                </ul>\r\n            </li> -->\r\n            <li class=\"dropdown\">\r\n                <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" aria-expanded=\"false\">\r\n                    <i class=\"material-icons\">person</i>\r\n                    <p class=\"hidden-lg hidden-md\">Profil</p>\r\n                    <div class=\"ripple-container\"></div>\r\n                </a>\r\n                <ul class=\"dropdown-menu\">\r\n                    <li>\r\n                        <a (click)=\"onEditLoggedUser()\">Korisnička podešavanja</a>\r\n                    </li>\r\n                    <li>\r\n                        <a (click)=\"onLogout()\">Odjavi se</a>\r\n                    </li>\r\n                </ul>\r\n            </li>\r\n            <li class=\"separator hidden-lg hidden-md\"></li>\r\n        </ul>\r\n    </div>\r\n    <div class=\"nav-container\">\r\n        <ul class=\"nav\">\r\n            <li routerLinkActive=\"active\">\r\n                <a [routerLink]=\"[menuItems[0].path]\">\r\n                    <i class=\"{{menuItems[0].icon}}\">dashboard</i>\r\n                    <p>{{menuItems[0].title}}</p>\r\n                </a>\r\n            </li>\r\n            <li routerLinkActive=\"active\">\r\n                <a [routerLink]=\"[menuItems[1].path]\">\r\n                    <i class=\"{{menuItems[1].icon}}\">supervisor_account</i>\r\n                    <p>{{menuItems[1].title}}</p>\r\n                </a>\r\n            </li>\r\n\r\n            <li routerLinkActive=\"active\">\r\n                <a [routerLink]=\"[menuItems[2].path]\">\r\n                    <i class=\"{{menuItems[2].icon}}\">store</i>\r\n                    <p>{{menuItems[2].title}}</p>\r\n                </a>\r\n            </li>\r\n\r\n            <li routerLinkActive=\"active\">\r\n                <a [routerLink]=\"[menuItems[3].path]\">\r\n                    <i class=\"{{menuItems[3].icon}}\">local_bar</i>\r\n                    <p>{{menuItems[3].title}}</p>\r\n                </a>\r\n            </li>\r\n\r\n            <li routerLinkActive=\"active\">\r\n                <a [routerLink]=\"[menuItems[4].path]\">\r\n                    <i class=\"{{menuItems[4].icon}}\">event</i>\r\n                    <p>{{menuItems[4].title}}</p>\r\n                </a>\r\n            </li>\r\n\r\n            <li routerLinkActive=\"active\">\r\n                <a [routerLink]=\"[menuItems[5].path]\">\r\n                    <i class=\"{{menuItems[5].icon}}\">timeline</i>\r\n\r\n                    <p>{{menuItems[5].title}}</p>\r\n                </a>\r\n            </li>\r\n            <!--\r\n            <li routerLinkActive=\"active\">\r\n                <a [routerLink]=\"[menuItems[6].path]\">\r\n                    <i class=\"{{menuItems[6].icon}}\">add_location</i>\r\n\r\n                    <p>{{menuItems[6].title}}</p>\r\n                </a>\r\n            </li>\r\n            <li routerLinkActive=\"active\">\r\n                <a [routerLink]=\"[menuItems[7].path]\">\r\n                    <i class=\"{{menuItems[7].icon}}\">description</i>\r\n\r\n                    <p>{{menuItems[7].title}}</p>\r\n                </a>\r\n            </li>\r\n\r\n            <li routerLinkActive=\"active\">\r\n                <a [routerLink]=\"[menuItems[8].path]\">\r\n                    <i class=\"{{menuItems[8].icon}}\">chat</i>\r\n\r\n                    <p>{{menuItems[8].title}}</p>\r\n                </a>\r\n            </li>\r\n\r\n            <li routerLinkActive=\"active\">\r\n                <a [routerLink]=\"[menuItems[9].path]\">\r\n                    <i class=\"{{menuItems[9].icon}}\">notifications</i>\r\n                    <p>{{menuItems[9].title}}</p>\r\n                </a>\r\n            </li>\r\n\r\n            <li routerLinkActive=\"active\">\r\n                <a [routerLink]=\"[menuItems[10].path]\">\r\n                    <i class=\"{{menuItems[10].icon}}\">settings</i>\r\n\r\n                    <p>{{menuItems[10].title}}</p>\r\n                </a>\r\n            </li> -->\r\n        </ul>\r\n    </div>\r\n</div>"

/***/ }),

/***/ "./src/app/sidebar/sidebar.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return SidebarComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__sidebar_routes_config__ = __webpack_require__("./src/app/sidebar/sidebar-routes.config.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__services_localstorage_service__ = __webpack_require__("./src/app/services/localstorage.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};




var sidebarTimer;
var SidebarComponent = /** @class */ (function () {
    function SidebarComponent(ls, router) {
        this.ls = ls;
        this.router = router;
    }
    SidebarComponent.prototype.isNotMobileMenu = function () {
        if ($(window).width() > 991) {
            return false;
        }
        return true;
    };
    SidebarComponent.prototype.ngOnInit = function () {
        this.user = this.ls.get('user');
        var isWindows = navigator.platform.indexOf('Win') > -1 ? true : false;
        if (isWindows) {
            // if we are on windows OS we activate the perfectScrollbar function
            var $sidebar = $('.sidebar-wrapper');
            $sidebar.perfectScrollbar();
        }
        this.menuItems = __WEBPACK_IMPORTED_MODULE_1__sidebar_routes_config__["a" /* ROUTES */].filter(function (menuItem) { return menuItem; });
        isWindows = navigator.platform.indexOf('Win') > -1 ? true : false;
        if (isWindows) {
            // if we are on windows OS we activate the perfectScrollbar function
            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();
            $('html').addClass('perfect-scrollbar-on');
        }
        else {
            $('html').addClass('perfect-scrollbar-off');
        }
    };
    SidebarComponent.prototype.ngAfterViewInit = function () {
        // init Moving Tab after the view is initialisez
        setTimeout(function () {
            if (mda.movingTabInitialised == false) {
                mda.initMovingTab();
                mda.movingTabInitialised = true;
            }
        }, 10);
    };
    SidebarComponent.prototype.onLogout = function () {
        this.ls.remove('token');
        this.ls.remove('user');
        this.router.navigate(['login']);
    };
    SidebarComponent.prototype.onEditLoggedUser = function () {
        var id = this.ls.get('user_id');
        this.router.navigate(['users/edit/' + id]);
    };
    SidebarComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            moduleId: module.i,
            selector: 'sidebar-cmp',
            template: __webpack_require__("./src/app/sidebar/sidebar.component.html"),
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_2__services_localstorage_service__["a" /* LocalStorageService */], __WEBPACK_IMPORTED_MODULE_3__angular_router__["b" /* Router */]])
    ], SidebarComponent);
    return SidebarComponent;
}());

// The Moving Tab (the element that is moving on the sidebar, when you switch the pages) is depended on jQuery because it is doing a lot of calculations and changes based on Bootstrap collapse elements. If you have a better suggestion please send it to hello@creative-tim.com and we would be glad to talk more about this improvement. Thank you!
var mda = {
    movingTab: '<div class="sidebar-moving-tab"/>',
    isChild: false,
    sidebarMenuActive: '',
    movingTabInitialised: false,
    distance: 0,
    setMovingTabPosition: function ($currentActive) {
        $currentActive = mda.sidebarMenuActive;
        mda.distance = $currentActive.parent().position().top - 10;
        if ($currentActive.closest('.collapse').length != 0) {
            var parent_distance = $currentActive.closest('.collapse').parent().position().top;
            mda.distance = mda.distance + parent_distance;
        }
        mda.moveTab();
    },
    initMovingTab: function () {
        mda.movingTab = $(mda.movingTab);
        mda.sidebarMenuActive = $('.sidebar .nav-container > .nav > li.active > a:not([data-toggle="collapse"]');
        if (mda.sidebarMenuActive.length != 0) {
            mda.setMovingTabPosition(mda.sidebarMenuActive);
        }
        else {
            mda.sidebarMenuActive = $('.sidebar .nav-container .nav > li.active .collapse li.active > a');
            mda.isChild = true;
            this.setParentCollapse();
        }
        mda.sidebarMenuActive.parent().addClass('visible');
        var button_text = mda.sidebarMenuActive.html();
        mda.movingTab.html(button_text);
        $('.sidebar .nav-container').append(mda.movingTab);
        if (window.history && window.history.pushState) {
            $(window).on('popstate', function () {
                setTimeout(function () {
                    mda.sidebarMenuActive = $('.sidebar .nav-container .nav li.active a:not([data-toggle="collapse"])');
                    if (mda.isChild == true) {
                        this.setParentCollapse();
                    }
                    clearTimeout(sidebarTimer);
                    var $currentActive = mda.sidebarMenuActive;
                    $('.sidebar .nav-container .nav li').removeClass('visible');
                    var $movingTab = mda.movingTab;
                    $movingTab.addClass('moving');
                    $movingTab.css('padding-left', $currentActive.css('padding-left'));
                    var button_text = $currentActive.html();
                    mda.setMovingTabPosition($currentActive);
                    sidebarTimer = setTimeout(function () {
                        $movingTab.removeClass('moving');
                        $currentActive.parent().addClass('visible');
                    }, 650);
                    setTimeout(function () {
                        $movingTab.html(button_text);
                    }, 10);
                }, 10);
            });
        }
        $('.sidebar .nav .collapse').on('hidden.bs.collapse', function () {
            var $currentActive = mda.sidebarMenuActive;
            mda.distance = $currentActive.parent().position().top - 10;
            if ($currentActive.closest('.collapse').length != 0) {
                var parent_distance = $currentActive.closest('.collapse').parent().position().top;
                mda.distance = mda.distance + parent_distance;
            }
            mda.moveTab();
        });
        $('.sidebar .nav .collapse').on('shown.bs.collapse', function () {
            var $currentActive = mda.sidebarMenuActive;
            mda.distance = $currentActive.parent().position().top - 10;
            if ($currentActive.closest('.collapse').length != 0) {
                var parent_distance = $currentActive.closest('.collapse').parent().position().top;
                mda.distance = mda.distance + parent_distance;
            }
            mda.moveTab();
        });
        $('.sidebar .nav-container .nav > li > a:not([data-toggle="collapse"])').click(function () {
            mda.sidebarMenuActive = $(this);
            var $parent = $(this).parent();
            if (mda.sidebarMenuActive.closest('.collapse').length == 0) {
                mda.isChild = false;
            }
            // we call the animation of the moving tab
            clearTimeout(sidebarTimer);
            var $currentActive = mda.sidebarMenuActive;
            $('.sidebar .nav-container .nav li').removeClass('visible');
            var $movingTab = mda.movingTab;
            $movingTab.addClass('moving');
            $movingTab.css('padding-left', $currentActive.css('padding-left'));
            var button_text = $currentActive.html();
            var $currentActive = mda.sidebarMenuActive;
            mda.distance = $currentActive.parent().position().top - 10;
            if ($currentActive.closest('.collapse').length != 0) {
                var parent_distance = $currentActive.closest('.collapse').parent().position().top;
                mda.distance = mda.distance + parent_distance;
            }
            mda.moveTab();
            sidebarTimer = setTimeout(function () {
                $movingTab.removeClass('moving');
                $currentActive.parent().addClass('visible');
            }, 650);
            setTimeout(function () {
                $movingTab.html(button_text);
            }, 10);
        });
    },
    setParentCollapse: function () {
        if (mda.isChild == true) {
            var $sidebarParent = mda.sidebarMenuActive.parent().parent().parent();
            var collapseId = $sidebarParent.siblings('a').attr("href");
            $(collapseId).collapse("show");
            $(collapseId).collapse()
                .on('shown.bs.collapse', function () {
                mda.setMovingTabPosition();
            })
                .on('hidden.bs.collapse', function () {
                mda.setMovingTabPosition();
            });
        }
    },
    animateMovingTab: function () {
        clearTimeout(sidebarTimer);
        var $currentActive = mda.sidebarMenuActive;
        $('.sidebar .nav-container .nav li').removeClass('visible');
        var $movingTab = mda.movingTab;
        $movingTab.addClass('moving');
        $movingTab.css('padding-left', $currentActive.css('padding-left'));
        var button_text = $currentActive.html();
        mda.setMovingTabPosition($currentActive);
        sidebarTimer = setTimeout(function () {
            $movingTab.removeClass('moving');
            $currentActive.parent().addClass('visible');
        }, 650);
        setTimeout(function () {
            $movingTab.html(button_text);
        }, 10);
    },
    moveTab: function () {
        mda.movingTab.css({
            'transform': 'translate3d(0px,' + mda.distance + 'px, 0)',
            '-webkit-transform': 'translate3d(0px,' + mda.distance + 'px, 0)',
            '-moz-transform': 'translate3d(0px,' + mda.distance + 'px, 0)',
            '-ms-transform': 'translate3d(0px,' + mda.distance + 'px, 0)',
            '-o-transform': 'translate3d(0px,' + mda.distance + 'px, 0)'
        });
    }
};


/***/ }),

/***/ "./src/app/sidebar/sidebar.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return SidebarModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_common__ = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__sidebar_component__ = __webpack_require__("./src/app/sidebar/sidebar.component.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};




var SidebarModule = /** @class */ (function () {
    function SidebarModule() {
    }
    SidebarModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [__WEBPACK_IMPORTED_MODULE_2__angular_router__["c" /* RouterModule */], __WEBPACK_IMPORTED_MODULE_1__angular_common__["b" /* CommonModule */]],
            declarations: [__WEBPACK_IMPORTED_MODULE_3__sidebar_component__["a" /* SidebarComponent */]],
            exports: [__WEBPACK_IMPORTED_MODULE_3__sidebar_component__["a" /* SidebarComponent */]]
        })
    ], SidebarModule);
    return SidebarModule;
}());



/***/ }),

/***/ "./src/environments/environment.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return environment; });
// The file contents for the current environment will overwrite these during build.
// The build system defaults to the dev environment which uses `environment.ts`, but if you do
// `ng build --env=prod` then `environment.prod.ts` will be used instead.
// The list of which env maps to which file can be found in `.angular-cli.json`.
var environment = {
    production: true
};


/***/ }),

/***/ "./src/main.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_platform_browser_dynamic__ = __webpack_require__("./node_modules/@angular/platform-browser-dynamic/esm5/platform-browser-dynamic.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__app_app_module__ = __webpack_require__("./src/app/app.module.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__environments_environment__ = __webpack_require__("./src/environments/environment.ts");




if (__WEBPACK_IMPORTED_MODULE_3__environments_environment__["a" /* environment */].production) {
    Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["enableProdMode"])();
}
Object(__WEBPACK_IMPORTED_MODULE_1__angular_platform_browser_dynamic__["a" /* platformBrowserDynamic */])().bootstrapModule(__WEBPACK_IMPORTED_MODULE_2__app_app_module__["a" /* AppModule */]);


/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./src/main.ts");


/***/ })

},[0]);
//# sourceMappingURL=main.bundle.js.map