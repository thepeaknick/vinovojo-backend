webpackJsonp(["pages.module"],{

/***/ "./src/app/pages/lock/lock.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"wrapper wrapper-full-page\">\r\n    <nav class=\"navbar navbar-primary navbar-transparent navbar-fixed-top\">\r\n        <div class=\"container\">\r\n            <div class=\"navbar-header\">\r\n                <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#menu-example\">\r\n                    <span class=\"sr-only\">Toggle navigation</span>\r\n                    <span class=\"icon-bar\"></span>\r\n                    <span class=\"icon-bar\"></span>\r\n                    <span class=\"icon-bar\"></span>\r\n                </button>\r\n                <a class=\"navbar-brand\" href=\"/#/dashboard\">MD Pro Angular</a>\r\n            </div>\r\n            <div class=\"collapse navbar-collapse\" id=\"menu-example\">\r\n                <ul class=\"nav navbar-nav navbar-right\">\r\n                    <li>\r\n                        <a href=\"/dashboard\">\r\n                            <i class=\"material-icons\">dashboard</i> Dashboard\r\n                        </a>\r\n                    </li>\r\n                    <li class=\"\">\r\n                        <a href=\"/pages/register\">\r\n                            <i class=\"material-icons\">person_add</i> Register\r\n                        </a>\r\n                    </li>\r\n                    <li class=\"\">\r\n                        <a href=\"/pages/login\">\r\n                            <i class=\"material-icons\">fingerprint</i> Login\r\n                        </a>\r\n                    </li>\r\n                    <li class=\" active \">\r\n                        <a href=\"/pages/lock\">\r\n                            <i class=\"material-icons\">lock_open</i> Lock\r\n                        </a>\r\n                    </li>\r\n                </ul>\r\n            </div>\r\n        </div>\r\n    </nav>\r\n    <div class=\"full-page lock-page\" filter-color=\"black\" data-image=\"../assets/img/lock.jpeg\">\r\n        <!--   you can change the color of the filter page using: data-color=\"blue | green | orange | red | purple\" -->\r\n        <div class=\"content\">\r\n            <form method=\"#\" action=\"#\">\r\n                <div class=\"card card-profile card-hidden\">\r\n                    <div class=\"card-avatar\">\r\n                        <a href=\"#pablo\">\r\n                            <img class=\"avatar\" src=\"../assets/img/faces/avatar.jpg\" alt=\"...\">\r\n                        </a>\r\n                    </div>\r\n                    <div class=\"card-content\">\r\n                        <h4 class=\"card-title\">Tania Andrew</h4>\r\n                        <div class=\"form-group label-floating\">\r\n                            <label class=\"control-label\">Enter Password</label>\r\n                            <input type=\"password\" class=\"form-control\">\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"card-footer\">\r\n                        <button type=\"button\" class=\"btn btn-rose btn-round\">Unlock</button>\r\n                    </div>\r\n                </div>\r\n            </form>\r\n        </div>\r\n        <footer class=\"footer\">\r\n            <div class=\"container\">\r\n                <nav class=\"pull-left\">\r\n                    <ul>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Home\r\n                            </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Company\r\n                            </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Portfolio\r\n                            </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Blog\r\n                            </a>\r\n                        </li>\r\n                    </ul>\r\n                </nav>\r\n                <p class=\"copyright pull-right\">\r\n                    &copy;\r\n                    {{test | date: 'yyyy'}}\r\n                    <a href=\"https://www.creative-tim.com\">Creative Tim</a>, made with love for a better web\r\n                </p>\r\n            </div>\r\n        </footer>\r\n    </div>\r\n</div>\r\n"

/***/ }),

/***/ "./src/app/pages/lock/lock.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return LockComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};

var LockComponent = /** @class */ (function () {
    function LockComponent() {
        this.test = new Date();
    }
    LockComponent.prototype.checkFullPageBackgroundImage = function () {
        var $page = $('.full-page');
        var image_src = $page.data('image');
        if (image_src !== undefined) {
            var image_container = '<div class="full-page-background" style="background-image: url(' + image_src + ') "/>';
            $page.append(image_container);
        }
    };
    ;
    LockComponent.prototype.ngOnInit = function () {
        this.checkFullPageBackgroundImage();
        setTimeout(function () {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700);
    };
    LockComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            moduleId: module.i,
            selector: 'lock-cmp',
            template: __webpack_require__("./src/app/pages/lock/lock.component.html")
        })
    ], LockComponent);
    return LockComponent;
}());



/***/ }),

/***/ "./src/app/pages/login/login.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"wrapper wrapper-full-page\">\r\n    <nav class=\"navbar navbar-primary navbar-transparent navbar-fixed-top\">\r\n        <div class=\"container\">\r\n            <div class=\"navbar-header\">\r\n                <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#menu-example\">\r\n                    <span class=\"sr-only\">Toggle navigation</span>\r\n                    <span class=\"icon-bar\"></span>\r\n                    <span class=\"icon-bar\"></span>\r\n                    <span class=\"icon-bar\"></span>\r\n                </button>\r\n                <a class=\"navbar-brand\" href=\"/#/dashboard\">MD Pro Angular</a>\r\n            </div>\r\n            <div class=\"collapse navbar-collapse\" id=\"menu-example\">\r\n                <ul class=\"nav navbar-nav navbar-right\">\r\n                    <li>\r\n                        <a href=\"/dashboard\">\r\n                            <i class=\"material-icons\">dashboard</i> Dashboard\r\n                        </a>\r\n                    </li>\r\n                    <li class=\"\">\r\n                        <a href=\"/pages/register\">\r\n                            <i class=\"material-icons\">person_add</i> Register\r\n                        </a>\r\n                    </li>\r\n                    <li class=\" active \">\r\n                        <a href=\"/pages/login\">\r\n                            <i class=\"material-icons\">fingerprint</i> Login\r\n                        </a>\r\n                    </li>\r\n                    <li class=\"\">\r\n                        <a href=\"/pages/lock\">\r\n                            <i class=\"material-icons\">lock_open</i> Lock\r\n                        </a>\r\n                    </li>\r\n                </ul>\r\n            </div>\r\n        </div>\r\n    </nav>\r\n    <div class=\"full-page login-page\" filter-color=\"black\" data-image=\"../../../assets/img/login.jpeg\">\r\n        <!--   you can change the color of the filter page using: data-color=\"blue | purple | green | orange | red | rose \" -->\r\n        <div class=\"content\">\r\n            <div class=\"container\">\r\n                <div class=\"row\">\r\n                    <div class=\"col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3\">\r\n                        <form method=\"#\" action=\"#\">\r\n                            <div class=\"card card-login card-hidden\">\r\n                                <div class=\"card-header text-center\" data-background-color=\"rose\">\r\n                                    <h4 class=\"card-title\">Login</h4>\r\n                                    <div class=\"social-line\">\r\n                                        <a href=\"#btn\" class=\"btn btn-just-icon btn-simple\">\r\n                                            <i class=\"fa fa-facebook-square\"></i>\r\n                                        </a>\r\n                                        <a href=\"#pablo\" class=\"btn btn-just-icon btn-simple\">\r\n                                            <i class=\"fa fa-twitter\"></i>\r\n                                        </a>\r\n                                        <a href=\"#eugen\" class=\"btn btn-just-icon btn-simple\">\r\n                                            <i class=\"fa fa-google-plus\"></i>\r\n                                        </a>\r\n                                    </div>\r\n                                </div>\r\n                                <p class=\"category text-center\">\r\n                                    Or Be Classical\r\n                                </p>\r\n                                <div class=\"card-content\">\r\n                                    <div class=\"input-group\">\r\n                                        <span class=\"input-group-addon\">\r\n                                            <i class=\"material-icons\">face</i>\r\n                                        </span>\r\n                                        <div class=\"form-group label-floating\">\r\n                                            <label class=\"control-label\">First Name</label>\r\n                                            <input type=\"text\" class=\"form-control\">\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"input-group\">\r\n                                        <span class=\"input-group-addon\">\r\n                                            <i class=\"material-icons\">email</i>\r\n                                        </span>\r\n                                        <div class=\"form-group label-floating\">\r\n                                            <label class=\"control-label\">Email address</label>\r\n                                            <input type=\"email\" class=\"form-control\">\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"input-group\">\r\n                                        <span class=\"input-group-addon\">\r\n                                            <i class=\"material-icons\">lock_outline</i>\r\n                                        </span>\r\n                                        <div class=\"form-group label-floating\">\r\n                                            <label class=\"control-label\">Password</label>\r\n                                            <input type=\"password\" class=\"form-control\">\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"footer text-center\">\r\n                                    <button type=\"submit\" class=\"btn btn-rose btn-simple btn-wd btn-lg\">Let's go</button>\r\n                                </div>\r\n                            </div>\r\n                        </form>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <footer class=\"footer\">\r\n            <div class=\"container\">\r\n                <nav class=\"pull-left\">\r\n                    <ul>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Home\r\n                            </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Company\r\n                            </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Portfolio\r\n                            </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Blog\r\n                            </a>\r\n                        </li>\r\n                    </ul>\r\n                </nav>\r\n                <p class=\"copyright pull-right\">\r\n                    &copy;\r\n                    {{test | date: 'yyyy'}}\r\n                    <a href=\"https://www.creative-tim.com\">Creative Tim</a>, made with love for a better web\r\n                </p>\r\n            </div>\r\n        </footer>\r\n    </div>\r\n</div>\r\n"

/***/ }),

/***/ "./src/app/pages/login/login.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return LoginComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};

var LoginComponent = /** @class */ (function () {
    function LoginComponent() {
        this.test = new Date();
    }
    LoginComponent.prototype.checkFullPageBackgroundImage = function () {
        var $page = $('.full-page');
        var image_src = $page.data('image');
        if (image_src !== undefined) {
            var image_container = '<div class="full-page-background" style="background-image: url(' + image_src + ') "/>';
            $page.append(image_container);
        }
    };
    ;
    LoginComponent.prototype.ngOnInit = function () {
        this.checkFullPageBackgroundImage();
        setTimeout(function () {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700);
    };
    LoginComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            moduleId: module.i,
            selector: 'login-cmp',
            template: __webpack_require__("./src/app/pages/login/login.component.html")
        })
    ], LoginComponent);
    return LoginComponent;
}());



/***/ }),

/***/ "./src/app/pages/pages.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "PagesModule", function() { return PagesModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_common__ = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__pages_routing__ = __webpack_require__("./src/app/pages/pages.routing.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__register_register_component__ = __webpack_require__("./src/app/pages/register/register.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__pricing_pricing_component__ = __webpack_require__("./src/app/pages/pricing/pricing.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__lock_lock_component__ = __webpack_require__("./src/app/pages/lock/lock.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__login_login_component__ = __webpack_require__("./src/app/pages/login/login.component.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



// import { MdIconModule, MdCardModule, MdInputModule, MdCheckboxModule, MdButtonModule } from '@angular/material';

// import { FlexLayoutModule } from '@angular/flex-layout';





var PagesModule = /** @class */ (function () {
    function PagesModule() {
    }
    PagesModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [
                __WEBPACK_IMPORTED_MODULE_2__angular_common__["b" /* CommonModule */],
                __WEBPACK_IMPORTED_MODULE_1__angular_router__["c" /* RouterModule */].forChild(__WEBPACK_IMPORTED_MODULE_4__pages_routing__["a" /* PagesRoutes */]),
                __WEBPACK_IMPORTED_MODULE_3__angular_forms__["e" /* FormsModule */],
                __WEBPACK_IMPORTED_MODULE_3__angular_forms__["k" /* ReactiveFormsModule */]
            ],
            declarations: [
                __WEBPACK_IMPORTED_MODULE_8__login_login_component__["a" /* LoginComponent */],
                __WEBPACK_IMPORTED_MODULE_5__register_register_component__["a" /* RegisterComponent */],
                __WEBPACK_IMPORTED_MODULE_6__pricing_pricing_component__["a" /* PricingComponent */],
                __WEBPACK_IMPORTED_MODULE_7__lock_lock_component__["a" /* LockComponent */]
            ]
        })
    ], PagesModule);
    return PagesModule;
}());



/***/ }),

/***/ "./src/app/pages/pages.routing.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return PagesRoutes; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__register_register_component__ = __webpack_require__("./src/app/pages/register/register.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__pricing_pricing_component__ = __webpack_require__("./src/app/pages/pricing/pricing.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__lock_lock_component__ = __webpack_require__("./src/app/pages/lock/lock.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__login_login_component__ = __webpack_require__("./src/app/pages/login/login.component.ts");




var PagesRoutes = [
    {
        path: '',
        children: [{
                path: 'login',
                component: __WEBPACK_IMPORTED_MODULE_3__login_login_component__["a" /* LoginComponent */]
            }, {
                path: 'lock',
                component: __WEBPACK_IMPORTED_MODULE_2__lock_lock_component__["a" /* LockComponent */]
            }, {
                path: 'register',
                component: __WEBPACK_IMPORTED_MODULE_0__register_register_component__["a" /* RegisterComponent */]
            }, {
                path: 'pricing',
                component: __WEBPACK_IMPORTED_MODULE_1__pricing_pricing_component__["a" /* PricingComponent */]
            }]
    }
];


/***/ }),

/***/ "./src/app/pages/pricing/pricing.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"wrapper wrapper-full-page\">\r\n    <nav class=\"navbar navbar-primary navbar-transparent navbar-absolute\">\r\n        <div class=\"container\">\r\n            <div class=\"navbar-header\">\r\n                <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#menu-example\">\r\n                    <span class=\"sr-only\">Toggle navigation</span>\r\n                    <span class=\"icon-bar\"></span>\r\n                    <span class=\"icon-bar\"></span>\r\n                    <span class=\"icon-bar\"></span>\r\n                </button>\r\n                <a class=\"navbar-brand\" href=\"/#/dashboard\">MD Pro Angular</a>\r\n            </div>\r\n            <div class=\"collapse navbar-collapse\" id=\"menu-example\">\r\n                <ul class=\"nav navbar-nav navbar-right\">\r\n                    <li>\r\n                        <a href=\"/dashboard\">\r\n                            <i class=\"material-icons\">dashboard</i> Dashboard\r\n                        </a>\r\n                    </li>\r\n                    <li class=\"\">\r\n                        <a href=\"/pages/register\">\r\n                            <i class=\"material-icons\">person_add</i> Register\r\n                        </a>\r\n                    </li>\r\n                    <li class=\"\">\r\n                        <a href=\"/pages/login\">\r\n                            <i class=\"material-icons\">fingerprint</i> Login\r\n                        </a>\r\n                    </li>\r\n                    <li class=\"\">\r\n                        <a href=\"/pages/lock\">\r\n                            <i class=\"material-icons\">lock_open</i> Lock\r\n                        </a>\r\n                    </li>\r\n                </ul>\r\n            </div>\r\n        </div>\r\n    </nav>\r\n    <div class=\"full-page pricing-page\" data-image=\"../assets/img/bg-pricing.jpeg\">\r\n        <div class=\"content\">\r\n            <div class=\"container\">\r\n                <div class=\"row\">\r\n                    <div class=\"col-md-6 col-md-offset-3 text-center\">\r\n                        <h2 class=\"title\">Pick the best plan for you</h2>\r\n                        <h5 class=\"description\">You have Free Unlimited Updates and Premium Support on each package.</h5>\r\n                    </div>\r\n                </div>\r\n                <div class=\"row\">\r\n                    <div class=\"col-md-3\">\r\n                        <div class=\"card card-pricing card-plain\">\r\n                            <div class=\"card-content\">\r\n                                <h6 class=\"category\">Freelancer</h6>\r\n                                <div class=\"icon\">\r\n                                    <i class=\"material-icons\">weekend</i>\r\n                                </div>\r\n                                <h3 class=\"card-title\">FREE</h3>\r\n                                <p class=\"card-description\">\r\n                                    This is good if your company size is between 2 and 10 Persons.\r\n                                </p>\r\n                                <a href=\"#pablo\" class=\"btn btn-white btn-round\">Choose Plan</a>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"col-md-3\">\r\n                        <div class=\"card card-pricing card-raised\">\r\n                            <div class=\"card-content\">\r\n                                <h6 class=\"category\">Small Company</h6>\r\n                                <div class=\"icon icon-rose\">\r\n                                    <i class=\"material-icons\">home</i>\r\n                                </div>\r\n                                <h3 class=\"card-title\">$29</h3>\r\n                                <p class=\"card-description\">\r\n                                    This is good if your company size is between 2 and 10 Persons.\r\n                                </p>\r\n                                <a href=\"#pablo\" class=\"btn btn-rose btn-round\">Choose Plan</a>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"col-md-3\">\r\n                        <div class=\"card card-pricing card-plain\">\r\n                            <div class=\"card-content\">\r\n                                <h6 class=\"category\">Medium Company</h6>\r\n                                <div class=\"icon\">\r\n                                    <i class=\"material-icons\">business</i>\r\n                                </div>\r\n                                <h3 class=\"card-title\">$69</h3>\r\n                                <p class=\"card-description\">\r\n                                    This is good if your company size is between 11 and 99 Persons.\r\n                                </p>\r\n                                <a href=\"#pablo\" class=\"btn btn-white btn-round\">Choose Plan</a>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"col-md-3\">\r\n                        <div class=\"card card-pricing card-plain\">\r\n                            <div class=\"card-content\">\r\n                                <h6 class=\"category\">Enterprise</h6>\r\n                                <div class=\"icon\">\r\n                                    <i class=\"material-icons\">account_balance</i>\r\n                                </div>\r\n                                <h3 class=\"card-title\">$159</h3>\r\n                                <p class=\"card-description\">\r\n                                    This is good if your company size is 99+ persons.\r\n                                </p>\r\n                                <a href=\"#pablo\" class=\"btn btn-white btn-round\">Choose Plan</a>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <footer class=\"footer\">\r\n            <div class=\"container\">\r\n                <nav class=\"pull-left\">\r\n                    <ul>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Home\r\n                            </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Company\r\n                            </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Portfolio\r\n                            </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Blog\r\n                            </a>\r\n                        </li>\r\n                    </ul>\r\n                </nav>\r\n                <p class=\"copyright pull-right\">\r\n                    &copy;\r\n                    {{test | date: 'yyyy'}}\r\n                    <a href=\"https://www.creative-tim.com\">Creative Tim</a>, made with love for a better web\r\n                </p>\r\n            </div>\r\n        </footer>\r\n    </div>\r\n</div>\r\n"

/***/ }),

/***/ "./src/app/pages/pricing/pricing.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return PricingComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};

var PricingComponent = /** @class */ (function () {
    function PricingComponent() {
        this.test = new Date();
    }
    PricingComponent.prototype.checkFullPageBackgroundImage = function () {
        var $page = $('.full-page');
        var image_src = $page.data('image');
        if (image_src !== undefined) {
            var image_container = '<div class="full-page-background" style="background-image: url(' + image_src + ') "/>';
            $page.append(image_container);
        }
    };
    ;
    PricingComponent.prototype.ngOnInit = function () {
        this.checkFullPageBackgroundImage();
    };
    PricingComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            moduleId: module.i,
            selector: 'pricing-cmp',
            template: __webpack_require__("./src/app/pages/pricing/pricing.component.html")
        })
    ], PricingComponent);
    return PricingComponent;
}());



/***/ }),

/***/ "./src/app/pages/register/register.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"wrapper wrapper-full-page\">\r\n    <nav class=\"navbar navbar-primary navbar-transparent navbar-absolute\">\r\n        <div class=\"container\">\r\n            <div class=\"navbar-header\">\r\n                <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#menu-example\">\r\n                    <span class=\"sr-only\">Toggle navigation</span>\r\n                    <span class=\"icon-bar\"></span>\r\n                    <span class=\"icon-bar\"></span>\r\n                    <span class=\"icon-bar\"></span>\r\n                </button>\r\n                <a class=\"navbar-brand\" href=\"/#/dashboard\">MD Pro Angular</a>\r\n            </div>\r\n            <div class=\"collapse navbar-collapse\" id=\"menu-example\">\r\n                <ul class=\"nav navbar-nav navbar-right\">\r\n                    <li>\r\n                        <a href=\"/dashboard\">\r\n                            <i class=\"material-icons\">dashboard</i> Dashboard\r\n                        </a>\r\n                    </li>\r\n                    <li class=\" active \">\r\n                        <a href=\"/pages/register\">\r\n                            <i class=\"material-icons\">person_add</i> Register\r\n                        </a>\r\n                    </li>\r\n                    <li class=\"\">\r\n                        <a href=\"/pages/login\">\r\n                            <i class=\"material-icons\">fingerprint</i> Login\r\n                        </a>\r\n                    </li>\r\n                    <li class=\"\">\r\n                        <a href=\"/pages/lock\">\r\n                            <i class=\"material-icons\">lock_open</i> Lock\r\n                        </a>\r\n                    </li>\r\n                </ul>\r\n            </div>\r\n        </div>\r\n    </nav>\r\n    <div class=\"full-page register-page\" filter-color=\"black\" data-image=\"../assets/img/register.jpeg\">\r\n        <div class=\"container\">\r\n            <div class=\"row\">\r\n                <div class=\"col-md-10 col-md-offset-1\">\r\n                    <div class=\"card card-signup\">\r\n                        <h2 class=\"card-title text-center\">Register</h2>\r\n                        <div class=\"row\">\r\n                            <div class=\"col-md-5 col-md-offset-1\">\r\n                                <div class=\"card-content\">\r\n                                    <div class=\"info info-horizontal\">\r\n                                        <div class=\"icon icon-rose\">\r\n                                            <i class=\"material-icons\">timeline</i>\r\n                                        </div>\r\n                                        <div class=\"description\">\r\n                                            <h4 class=\"info-title\">Marketing</h4>\r\n                                            <p class=\"description\">\r\n                                                We've created the marketing campaign of the website. It was a very interesting collaboration.\r\n                                            </p>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"info info-horizontal\">\r\n                                        <div class=\"icon icon-primary\">\r\n                                            <i class=\"material-icons\">code</i>\r\n                                        </div>\r\n                                        <div class=\"description\">\r\n                                            <h4 class=\"info-title\">Fully Coded in HTML5</h4>\r\n                                            <p class=\"description\">\r\n                                                We've developed the website with HTML5 and CSS3. The client has access to the code using GitHub.\r\n                                            </p>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"info info-horizontal\">\r\n                                        <div class=\"icon icon-info\">\r\n                                            <i class=\"material-icons\">group</i>\r\n                                        </div>\r\n                                        <div class=\"description\">\r\n                                            <h4 class=\"info-title\">Built Audience</h4>\r\n                                            <p class=\"description\">\r\n                                                There is also a Fully Customizable CMS Admin Dashboard for this product.\r\n                                            </p>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"col-md-5\">\r\n                                <div class=\"social text-center\">\r\n                                    <button class=\"btn btn-just-icon btn-round btn-twitter\">\r\n                                        <i class=\"fa fa-twitter\"></i>\r\n                                    </button>\r\n                                    <button class=\"btn btn-just-icon btn-round btn-dribbble\">\r\n                                        <i class=\"fa fa-dribbble\"></i>\r\n                                    </button>\r\n                                    <button class=\"btn btn-just-icon btn-round btn-facebook\">\r\n                                        <i class=\"fa fa-facebook\"> </i>\r\n                                    </button>\r\n                                    <h4> or be classical </h4>\r\n                                </div>\r\n                                <form class=\"form\" method=\"\" action=\"\">\r\n                                    <div class=\"card-content\">\r\n                                        <div class=\"input-group\">\r\n                                            <span class=\"input-group-addon\">\r\n                                                <i class=\"material-icons\">face</i>\r\n                                            </span>\r\n                                            <input type=\"text\" class=\"form-control\" placeholder=\"First Name...\">\r\n                                        </div>\r\n                                        <div class=\"input-group\">\r\n                                            <span class=\"input-group-addon\">\r\n                                                <i class=\"material-icons\">email</i>\r\n                                            </span>\r\n                                            <input type=\"text\" class=\"form-control\" placeholder=\"Email...\">\r\n                                        </div>\r\n                                        <div class=\"input-group\">\r\n                                            <span class=\"input-group-addon\">\r\n                                                <i class=\"material-icons\">lock_outline</i>\r\n                                            </span>\r\n                                            <input type=\"password\" placeholder=\"Password...\" class=\"form-control\" />\r\n                                        </div>\r\n                                        <!-- If you want to add a checkbox to this form, uncomment this code -->\r\n                                        <div class=\"checkbox\">\r\n                                            <label>\r\n                                                <input type=\"checkbox\" name=\"optionsCheckboxes\" checked> I agree to the\r\n                                                <a href=\"#something\">terms and conditions</a>.\r\n                                            </label>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"footer text-center\">\r\n                                        <a href=\"#pablo\" class=\"btn btn-primary btn-round\">Get Started</a>\r\n                                    </div>\r\n                                </form>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <footer class=\"footer\">\r\n            <div class=\"container\">\r\n                <nav class=\"pull-left\">\r\n                    <ul>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Home\r\n                            </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Company\r\n                            </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Portfolio\r\n                            </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                                Blog\r\n                            </a>\r\n                        </li>\r\n                    </ul>\r\n                </nav>\r\n                <p class=\"copyright pull-right\">\r\n                    &copy;\r\n                    {{test | date: 'yyyy'}}\r\n                    <a href=\"https://www.creative-tim.com\">Creative Tim</a>, made with love for a better web\r\n                </p>\r\n            </div>\r\n        </footer>\r\n    </div>\r\n</div>\r\n"

/***/ }),

/***/ "./src/app/pages/register/register.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return RegisterComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};

var RegisterComponent = /** @class */ (function () {
    function RegisterComponent() {
        this.test = new Date();
    }
    RegisterComponent.prototype.checkFullPageBackgroundImage = function () {
        var $page = $('.full-page');
        var image_src = $page.data('image');
        if (image_src !== undefined) {
            var image_container = '<div class="full-page-background" style="background-image: url(' + image_src + ') "/>';
            $page.append(image_container);
        }
    };
    ;
    RegisterComponent.prototype.ngOnInit = function () {
        this.checkFullPageBackgroundImage();
    };
    RegisterComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            moduleId: module.i,
            selector: 'register-cmp',
            template: __webpack_require__("./src/app/pages/register/register.component.html")
        })
    ], RegisterComponent);
    return RegisterComponent;
}());



/***/ })

});
//# sourceMappingURL=pages.module.chunk.js.map