webpackJsonp(["login.module"],{

/***/ "./src/app/login/login.component.css":
/***/ (function(module, exports) {

module.exports = ".input-group {\r\n    width: 100%;\r\n}\r\n\r\n.form-full-width {\r\n    width: 100%;\r\n}"

/***/ }),

/***/ "./src/app/login/login.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"wrapper wrapper-full-page\">\r\n    <nav class=\"navbar navbar-primary navbar-transparent navbar-fixed-top\">\r\n        <div class=\"container\">\r\n            <div class=\"navbar-header\">\r\n                <!-- <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#menu-example\">\r\n                  <span class=\"sr-only\">Toggle navigation</span>\r\n                  <span class=\"icon-bar\"></span>\r\n                  <span class=\"icon-bar\"></span>\r\n                  <span class=\"icon-bar\"></span>\r\n              </button> -->\r\n                <a class=\"navbar-brand\" href=\"/#/dashboard\">MD Admin Panel VinoVojo</a>\r\n            </div>\r\n            <!-- <div class=\"collapse navbar-collapse\" id=\"menu-example\">\r\n                <ul class=\"nav navbar-nav navbar-right\">\r\n                    <li>\r\n                        <a href=\"/dashboard\">\r\n                            <i class=\"material-icons\">dashboard</i> Dashboard\r\n                        </a>\r\n                    </li>\r\n                    <li class=\"\">\r\n                        <a href=\"/pages/register\">\r\n                            <i class=\"material-icons\">person_add</i> Register\r\n                        </a>\r\n                    </li>\r\n                    <li class=\" active \">\r\n                        <a href=\"/pages/login\">\r\n                            <i class=\"material-icons\">fingerprint</i> Login\r\n                        </a>\r\n                    </li>\r\n                    <li class=\"\">\r\n                        <a href=\"/pages/lock\">\r\n                            <i class=\"material-icons\">lock_open</i> Lock\r\n                        </a>\r\n                    </li>\r\n                </ul>\r\n            </div> -->\r\n        </div>\r\n    </nav>\r\n    <div class=\"full-page login-page\" filter-color=\"black\" data-image=\"../../../assets/img/login.jpeg\">\r\n        <!--   you can change the color of the filter page using: data-color=\"blue | purple | green | orange | red | rose \" -->\r\n        <div class=\"content\">\r\n            <div class=\"container\">\r\n                <div class=\"row\">\r\n                    <div class=\"col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3\">\r\n                        <form [formGroup]=\"loginForm\" novalidate (ngSubmit)=\"onSubmit()\">\r\n                            <div class=\"card card-login card-hidden\">\r\n                                <div class=\"card-header text-center\" data-background-color=\"darkred\">\r\n                                    <h4 class=\"card-title\">Login</h4>\r\n                                    <!-- <div class=\"social-line\">\r\n                                        <a href=\"#btn\" class=\"btn btn-just-icon btn-simple\">\r\n                                            <i class=\"fa fa-facebook-square\"></i>\r\n                                        </a>\r\n                                        <a href=\"#pablo\" class=\"btn btn-just-icon btn-simple\">\r\n                                            <i class=\"fa fa-twitter\"></i>\r\n                                        </a>\r\n                                        <a href=\"#eugen\" class=\"btn btn-just-icon btn-simple\">\r\n                                            <i class=\"fa fa-google-plus\"></i>\r\n                                        </a>\r\n                                    </div> -->\r\n                                </div>\r\n                                <!-- <p class=\"category text-center\">\r\n                                    Or Be Classical\r\n                                </p> -->\r\n                                <div class=\"card-content\">\r\n                                    <!-- <div class=\"input-group\">\r\n                                        <span class=\"input-group-addon\">\r\n                                          <i class=\"material-icons\">face</i>\r\n                                      </span>\r\n                                        <div class=\"form-group label-floating\">\r\n                                            <label class=\"control-label\">First Name</label>\r\n                                            <input type=\"text\" class=\"form-control\">\r\n                                        </div>\r\n                                    </div> -->\r\n                                    <div class=\"input-group\">\r\n                                        <mat-form-field class=\"form-full-width\">\r\n                                            <input type=\"email\" matInput placeholder=\"Email\" formControlName=\"email\">\r\n                                            <span matPrefix><i class=\"material-icons\">email</i></span>\r\n                                            <mat-error>\r\n                                                <span *ngIf=\"loginForm.controls.email.hasError('required')\">This field is <strong>required</strong></span>\r\n                                                <span *ngIf=\"loginForm.controls.email.hasError('pattern')\">Email is not correct <strong>check for pattern</strong></span>\r\n                                            </mat-error>\r\n                                        </mat-form-field>\r\n                                    </div>\r\n                                    <div class=\"input-group\">\r\n                                        <mat-form-field class=\"form-full-width\">\r\n                                            <input type=\"password\" matInput placeholder=\"Password\" formControlName=\"password\">\r\n                                            <span matPrefix><i class=\"material-icons\">lock_outline</i></span>\r\n                                            <mat-error>\r\n                                                <span *ngIf=\"loginForm.controls.password.hasError('required')\">This field is <strong>required</strong></span>\r\n                                            </mat-error>\r\n                                        </mat-form-field>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"footer text-center\">\r\n                                    <button type=\"submit\" class=\"btn btn-rose btn-simple btn-wd btn-lg\">Let's go</button>\r\n                                </div>\r\n                            </div>\r\n                        </form>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <footer class=\"footer\">\r\n            <div class=\"container\">\r\n                <!-- <nav class=\"pull-left\">\r\n                    <ul>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                              Home\r\n                          </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                              Company\r\n                          </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                              Portfolio\r\n                          </a>\r\n                        </li>\r\n                        <li>\r\n                            <a href=\"#\">\r\n                              Blog\r\n                          </a>\r\n                        </li>\r\n                    </ul>\r\n                </nav> -->\r\n                <p class=\"copyright pull-right\">\r\n                    &copy; {{test | date: 'yyyy'}}\r\n                    <!-- <a href=\"https://www.itcentar.rs\">ItCentar Solutions</a>, made with love for a better web -->\r\n                </p>\r\n            </div>\r\n        </footer>\r\n    </div>\r\n</div>"

/***/ }),

/***/ "./src/app/login/login.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return LoginComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__services_http_service__ = __webpack_require__("./src/app/services/http.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__services_localstorage_service__ = __webpack_require__("./src/app/services/localstorage.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__notifications_notifications_service__ = __webpack_require__("./src/app/notifications/notifications.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};






var LoginComponent = /** @class */ (function () {
    function LoginComponent(http, fb, alert, router, ls // importing custom localstorage
    ) {
        this.http = http;
        this.fb = fb;
        this.alert = alert;
        this.router = router;
        this.ls = ls; // importing custom localstorage
        this.test = new Date(); // date year 
        this.emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
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
        // init form group for login form 
        this.loginForm = this.fb.group({
            email: ['', [__WEBPACK_IMPORTED_MODULE_2__angular_forms__["l" /* Validators */].required, __WEBPACK_IMPORTED_MODULE_2__angular_forms__["l" /* Validators */].pattern(this.emailPattern)]],
            password: ['', __WEBPACK_IMPORTED_MODULE_2__angular_forms__["l" /* Validators */].required]
        });
        // setting background image 
        this.checkFullPageBackgroundImage();
        setTimeout(function () {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700);
    };
    // on submitting form func
    LoginComponent.prototype.onSubmit = function () {
        var _this = this;
        // post method with saving token in localstorage as JSON
        console.log(this.loginForm.value);
        this.http.post('login', this.loginForm.value).subscribe(function (httpResponse) {
            if (httpResponse.status === 200) {
                _this.ls.set('token', httpResponse.json().token);
                _this.ls.set('user', httpResponse.json().user);
                _this.ls.set('user_id', httpResponse.json().user_id);
                _this.router.navigate(['']);
                console.log(httpResponse);
            }
        }, function (error) {
            if (error.status == 401) {
                _this.alert.showNotification('Email ili lozinka nisu ispravne , Molimo pokusajte ponovo!', 'danger', '');
            }
            console.log(error);
        });
    };
    LoginComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'app-login',
            template: __webpack_require__("./src/app/login/login.component.html"),
            styles: [__webpack_require__("./src/app/login/login.component.css")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__services_http_service__["a" /* HttpService */],
            __WEBPACK_IMPORTED_MODULE_2__angular_forms__["b" /* FormBuilder */],
            __WEBPACK_IMPORTED_MODULE_4__notifications_notifications_service__["a" /* NotificationsService */],
            __WEBPACK_IMPORTED_MODULE_5__angular_router__["b" /* Router */],
            __WEBPACK_IMPORTED_MODULE_3__services_localstorage_service__["a" /* LocalStorageService */] // importing custom localstorage
        ])
    ], LoginComponent);
    return LoginComponent;
}());



/***/ }),

/***/ "./src/app/login/login.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "LoginModule", function() { return LoginModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_common__ = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__login_routing__ = __webpack_require__("./src/app/login/login.routing.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__login_component__ = __webpack_require__("./src/app/login/login.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__angular_material__ = __webpack_require__("./node_modules/@angular/material/esm5/material.es5.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};




// import { MdIconModule, MdCardModule, MdInputModule, MdCheckboxModule, MdButtonModule } from '@angular/material';
// import { FlexLayoutModule } from '@angular/flex-layout';



var LoginModule = /** @class */ (function () {
    function LoginModule() {
    }
    LoginModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [
                __WEBPACK_IMPORTED_MODULE_2__angular_common__["b" /* CommonModule */],
                __WEBPACK_IMPORTED_MODULE_1__angular_router__["c" /* RouterModule */].forChild(__WEBPACK_IMPORTED_MODULE_4__login_routing__["a" /* LoginRoutes */]),
                __WEBPACK_IMPORTED_MODULE_3__angular_forms__["e" /* FormsModule */],
                __WEBPACK_IMPORTED_MODULE_3__angular_forms__["k" /* ReactiveFormsModule */],
                __WEBPACK_IMPORTED_MODULE_6__angular_material__["l" /* MatFormFieldModule */],
                __WEBPACK_IMPORTED_MODULE_6__angular_material__["o" /* MatInputModule */]
            ],
            declarations: [__WEBPACK_IMPORTED_MODULE_5__login_component__["a" /* LoginComponent */]],
            exports: [
                __WEBPACK_IMPORTED_MODULE_6__angular_material__["l" /* MatFormFieldModule */],
                __WEBPACK_IMPORTED_MODULE_6__angular_material__["o" /* MatInputModule */]
            ]
        })
    ], LoginModule);
    return LoginModule;
}());



/***/ }),

/***/ "./src/app/login/login.routing.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return LoginRoutes; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__login_component__ = __webpack_require__("./src/app/login/login.component.ts");

var LoginRoutes = [
    {
        path: '',
        children: [{
                path: '',
                component: __WEBPACK_IMPORTED_MODULE_0__login_component__["a" /* LoginComponent */]
            }]
    }
];


/***/ })

});
//# sourceMappingURL=login.module.chunk.js.map