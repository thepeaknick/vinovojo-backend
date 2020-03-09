webpackJsonp(["wines.module"],{

/***/ "./src/app/services/wine.datasource.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return WineDataSource; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_rxjs_BehaviorSubject__ = __webpack_require__("./node_modules/rxjs/_esm5/BehaviorSubject.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_rxjs_operators__ = __webpack_require__("./node_modules/rxjs/_esm5/operators.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_rxjs_observable_of__ = __webpack_require__("./node_modules/rxjs/_esm5/observable/of.js");



var WineDataSource = /** @class */ (function () {
    function WineDataSource(httpService) {
        this.httpService = httpService;
        this.wineSubject = new __WEBPACK_IMPORTED_MODULE_0_rxjs_BehaviorSubject__["a" /* BehaviorSubject */]([]);
        this.loadingSubject = new __WEBPACK_IMPORTED_MODULE_0_rxjs_BehaviorSubject__["a" /* BehaviorSubject */](false);
        this.loading$ = this.loadingSubject.asObservable();
    }
    WineDataSource.prototype.loadWines = function (pageIndex, lang) {
        var _this = this;
        this.loadingSubject.next(true);
        this.httpService.findWines('get/wine', lang, pageIndex).pipe(Object(__WEBPACK_IMPORTED_MODULE_1_rxjs_operators__["catchError"])(function () { return Object(__WEBPACK_IMPORTED_MODULE_2_rxjs_observable_of__["a" /* of */])([]); }), Object(__WEBPACK_IMPORTED_MODULE_1_rxjs_operators__["finalize"])(function () { return _this.loadingSubject.next(false); }))
            .subscribe(function (wines) { return _this.wineSubject.next(wines); });
    };
    WineDataSource.prototype.connect = function (collectionViewer) {
        return this.wineSubject.asObservable();
    };
    WineDataSource.prototype.disconnect = function (collectionViewer) {
        this.wineSubject.complete();
        this.loadingSubject.complete();
    };
    return WineDataSource;
}());



/***/ }),

/***/ "./src/app/wines/add/add.component.css":
/***/ (function(module, exports) {

module.exports = "ul.dropdown-menu.dropdown-menu-left {\r\n    cursor: pointer;\r\n}\r\n\r\ndiv#card-wine {\r\n    margin-top: 45px;\r\n}\r\n\r\nmat-form-field {\r\n    width: 100%;\r\n}\r\n\r\n#langDropdown {\r\n    margin-top: -10px;\r\n    position: absolute;\r\n    width: 100%;\r\n}\r\n\r\ni.fcancel.material-icons {\r\n    cursor: pointer;\r\n}\r\n\r\n.form-full-width {\r\n    width: 100%;\r\n}\r\n\r\n.image-tag {\r\n    font-size: 26px;\r\n}\r\n\r\n/* Rules for sizing the icon. */\r\n\r\n.material-icons.md-18 {\r\n    font-size: 18px;\r\n}\r\n\r\n.material-icons.md-24 {\r\n    font-size: 24px;\r\n}\r\n\r\n.material-icons.md-36 {\r\n    font-size: 36px;\r\n}\r\n\r\n.material-icons.md-48 {\r\n    font-size: 48px;\r\n}\r\n\r\n/* Rules for using icons as black on a light background. */\r\n\r\n.material-icons.md-dark {\r\n    color: rgba(0, 0, 0, 0.54);\r\n}\r\n\r\n.material-icons.md-dark.md-inactive {\r\n    color: rgba(0, 0, 0, 0.26);\r\n}\r\n\r\n/* Rules for using icons as white on a dark background. */\r\n\r\n.material-icons.md-light {\r\n    color: rgba(255, 255, 255, 1);\r\n}\r\n\r\n.material-icons.md-light.md-inactive {\r\n    color: rgba(255, 255, 255, 0.3);\r\n}"

/***/ }),

/***/ "./src/app/wines/add/add.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"main-content\">\r\n    <div class=\"container-fluid\">\r\n        <div class=\"row\">\r\n            <form [formGroup]=\"wineForm\" novalidate (ngSubmit)=\"onSubmit()\" #f=\"ngForm\">\r\n                <div class=\"col-md-offset-1 col-md-10\">\r\n                    <div class=\"col-md-12\">\r\n                        <div class=\"row\">\r\n                            <div class=\"dropdown\" *ngIf=\"wineForm.get('items').controls.length == 0\">\r\n                                <button class=\"dropdown-toggle btn btn-rose btn-block\" data-toggle=\"dropdown\">dodaj jezik<b class=\"caret\"></b></button>\r\n                                <ul class=\"dropdown-menu dropdown-menu-left\">\r\n                                    <li class=\"dropdown-header\">Izaberi jezik</li>\r\n                                    <li *ngFor=\"let lang of languagesData\">\r\n                                        <a (click)=\"addItem(lang)\">{{ lang.name }}</a>\r\n                                    </li>\r\n                                </ul>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                    <div formArrayName=\"items\" *ngFor=\"let item of wineForm.get('items').controls; let i = index;\">\r\n                        <div [formGroupName]=\"i\">\r\n                            <div class=\"col-md-12\">\r\n                                <div class=\"row\">\r\n                                    <div class=\"card\">\r\n                                        <div class=\"card-header card-header-icon\" data-background-color=\"darkred\">\r\n                                            <i class=\"material-icons\">language</i>\r\n                                        </div>\r\n                                        <div class=\"pull-right remove-btn\">\r\n                                            <h4 class=\"card-title\"><i (click)=\"onRemoveLangs(item.controls.language_name.value , item.controls.language_id.value ,  i)\" class=\"fcancel material-icons\">cancel</i></h4>\r\n                                        </div>\r\n                                        <div class=\"card-content\">\r\n                                            <h4 class=\"card-title\">{{item.controls['language_name'].value}}</h4>\r\n                                            <div class=\"col-md-offset-1 col-md-10\">\r\n                                                <div class=\"row\">\r\n                                                    <mat-form-field class=\"form-full-width\">\r\n                                                        <mat-label>Naziv vina</mat-label>\r\n                                                        <input matInput placeholder=\"Naziv\" formControlName=\"wineName\">\r\n                                                        <mat-error>\r\n                                                            <span *ngIf=\"item.controls['wineName'].touched && item.controls['wineName'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                                        </mat-error>\r\n                                                    </mat-form-field>\r\n                                                </div>\r\n                                                <div class=\"row \">\r\n                                                    <mat-form-field class=\"form-full-width\">\r\n                                                        <mat-label>Opis vina</mat-label>\r\n                                                        <textarea matInput placeholder=\"Wine Description\" rows=\"5\" formControlName=\"wineDesc\"></textarea>\r\n                                                        <mat-error>\r\n                                                            <span *ngIf=\"item.controls['wineDesc'].touched && item.controls['wineDesc'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                                        </mat-error>\r\n                                                    </mat-form-field>\r\n                                                    <div id=\"langDropdown\" class=\"dropdown\" *ngIf=\"wineForm.get('items').controls.length == i+1 && languagesData.length !== 0\">\r\n                                                        <button class=\"dropdown-toggle btn btn-rose btn-block\" data-toggle=\"dropdown\">dodaj jezik<b class=\"caret\"></b></button>\r\n                                                        <ul class=\"dropdown-menu dropdown-menu-left\">\r\n                                                            <li class=\"dropdown-header\">izaberi jezik</li>\r\n                                                            <li *ngFor=\"let lang of languagesData\">\r\n                                                                <a (click)=\"addItem(lang)\">{{ lang.name }}</a>\r\n                                                            </li>\r\n                                                        </ul>\r\n                                                    </div>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                    <div id=\"card-wine\" class=\"card\">\r\n                        <div class=\"card-header card-header-icon\" data-background-color=\"darkred\">\r\n                            <i class=\"material-icons\">assignment</i>\r\n                        </div>\r\n                        <div class=\"card-content\">\r\n                            <h4 class=\"card-title\">Forma za dodavanje vina</h4>\r\n                            <div class=\"row\">\r\n                                <div class=\"col-md-3\">\r\n                                    <div class=\"pull-left\">\r\n                                        <legend>Primer</legend>\r\n                                    </div>\r\n                                    <div class=\"fileinput fileinput-new text-center\" data-provides=\"fileinput\">\r\n                                        <div class=\"fileinput-new thumbnail\">\r\n                                            <img src=\"./assets/img/placeholder-177x600.png\" alt=\"...\">\r\n                                        </div>\r\n                                        <label class=\"image-tag\">177x600</label>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"col-md-3\">\r\n                                    <div class=\"pull-left\">\r\n                                        <legend>Slika vina</legend>\r\n                                    </div>\r\n                                    <div class=\"fileinput fileinput-new text-center\" data-provides=\"fileinput\">\r\n                                        <div class=\"fileinput-new thumbnail\">\r\n                                            <img src=\"./assets/img/image_placeholder.jpg\" alt=\"...\">\r\n                                        </div>\r\n                                        <div class=\"fileinput-preview fileinput-exists thumbnail\"></div>\r\n                                        <div>\r\n                                            <span class=\"btn btn-rose btn-block btn-file\">\r\n                                                <span class=\"fileinput-new\">Izaberi sliku vina</span>\r\n                                            <span class=\"fileinput-exists\">Promeni</span>\r\n                                            <input (change)=\"onUploadWineImage($event)\" type=\"file\" name=\"logo_image\" />\r\n                                            </span>\r\n                                            <a href=\"#\" #bottleImage class=\"btn btn-danger btn-round fileinput-exists\" data-dismiss=\"fileinput\"><i class=\"fa fa-times\"></i>Ukloni</a>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n\r\n                                <div class=\"col-md-6\">\r\n                                    <ul>\r\n                                        <li><strong>OBAVEŠTENJE! Odaberite da li želite da postavite pozadinu za sliku vina</strong></li>\r\n                                        <ul>\r\n                                            <li><strong>(postavi pozadinu) izaberite ukoliko je slika *jpg *jpeg formata, odnosno nema transparentu pozadinu</strong></li>\r\n                                        </ul>\r\n                                        <li><strong>OBAVEŠTENJE! Slika mora biti rezolucije 177 x 600 zbog adekvatnog prikaza u Android Aplikaciji</strong></li>\r\n                                    </ul>\r\n                                    <div class=\"checkbox-radios pull-left\">\r\n                                        <div class=\"radio\">\r\n                                            <mat-radio-group formControlName=\"background\" [value]=\"wineForm.controls['background'].value\">\r\n                                                <mat-radio-button [value]=\"1\"><strong>Postavi pozadinu</strong></mat-radio-button><br/>\r\n                                                <mat-radio-button [value]=\"0\"><strong>Ukloni pozadinu</strong></mat-radio-button>\r\n                                            </mat-radio-group>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"card\">\r\n                        <div class=\"card-content\">\r\n                            <div class=\"row\">\r\n                                <div class=\"col-md-12\">\r\n                                    <mat-form-field class=\"form-full-width\">\r\n                                        <mat-label>Sorta vina</mat-label>\r\n                                        <input matInput placeholder=\"Sorta\" formControlName=\"type\">\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['type'].touched && wineForm.controls['type'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"row\">\r\n                                <div class=\"col-md-4\">\r\n                                    <mat-form-field>\r\n                                        <mat-label>Kategorija vina</mat-label>\r\n                                        <mat-select formControlName=\"category_id\" placeholder=\"Kategorija\">\r\n                                            <mat-option *ngFor=\"let category of categories\" value=\"{{category.id}}\">{{category.name}}</mat-option>\r\n                                        </mat-select>\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['category_id'].touched && wineForm.controls['category_id'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                                <div class=\"col-md-4\">\r\n                                    <mat-form-field>\r\n                                        <mat-label>Regija porekla vina</mat-label>\r\n                                        <mat-select formControlName=\"area_id\" placeholder=\"Regija vina\">\r\n                                            <mat-option *ngFor=\"let area of areas\" value=\"{{area.id}}\">{{area.name}}</mat-option>\r\n                                        </mat-select>\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['area_id'].touched && wineForm.controls['area_id'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                                <div class=\"col-md-4\">\r\n                                    <mat-form-field>\r\n                                        <mat-label>Naziv vinarije</mat-label>\r\n                                        <mat-select formControlName=\"winery_id\" placeholder=\"Vinarija\">\r\n                                            <mat-option *ngFor=\"let winery of wineryList\" value=\"{{winery.id}}\">{{winery.name}}</mat-option>\r\n                                        </mat-select>\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['winery_id'].touched && wineForm.controls['winery_id'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"row\">\r\n                                <div class=\"col-md-4\">\r\n                                    <mat-form-field class=\"form-full-width\">\r\n                                        <mat-label>Godina berbe</mat-label>\r\n                                        <input matInput type=\"number\" placeholder=\"Godina\" min=\"0\" formControlName=\"harvest_year\">\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['harvest_year'].touched && wineForm.controls['harvest_year'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                                <div class=\"col-md-4\">\r\n                                    <mat-form-field class=\"form-full-width\">\r\n                                        <mat-label>Alkohol</mat-label>\r\n                                        <input matInput type=\"number\" placeholder=\"Procenat alkohola &#37;\" min=\"0\" formControlName=\"alcohol\">\r\n                                        <span matSuffix>&#37;</span>\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['alcohol'].touched && wineForm.controls['alcohol'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                                <div class=\"col-md-4\">\r\n                                    <mat-form-field class=\"form-full-width\">\r\n                                        <mat-label>Temperatura serviranja</mat-label>\r\n                                        <input matInput type=\"number\" placeholder=\"Temperatura u &#8451;\" formControlName=\"serving_temp\">\r\n                                        <span matSuffix>&#8451;</span>\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['serving_temp'].touched && wineForm.controls['serving_temp'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"row\">\r\n                                <div class=\"text-center\">\r\n                                    <button type=\"submit\" class=\"btn btn-rose btn-fill btn-wd\" [disabled]=\"!wineForm.valid\">DODAJ VINO\r\n                                        </button>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>\r\n</div>"

/***/ }),

/***/ "./src/app/wines/add/add.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AddComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__services_http_service__ = __webpack_require__("./src/app/services/http.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__notifications_notifications_service__ = __webpack_require__("./src/app/notifications/notifications.service.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};




var AddComponent = /** @class */ (function () {
    function AddComponent(fb, http, alert) {
        this.fb = fb;
        this.http = http;
        this.alert = alert;
        this.categories = []; // storage result of get request for list of categories
        this.areas = []; // storage result of get request for list of areas
        this.wineryList = []; // storage result of get request for list of wineries
        this.languagesData = []; // store all languages
    }
    AddComponent.prototype.ngOnInit = function () {
        var _this = this;
        // get all categories
        this.subscriptionCategory = this.http
            .get("dropdown/category", 1)
            .subscribe(function (httpResponse) {
            _this.categories = httpResponse.json();
        });
        // get all areas
        this.subscriptionArea = this.http
            .get("dropdown/area", 1)
            .subscribe(function (httpresponse) {
            _this.areas = httpresponse.json();
        });
        // get all wineries
        this.subscriptionWinery = this.http
            .get("dropdown/winery", 1)
            .subscribe(function (httpresponse) {
            _this.wineryList = httpresponse.json();
        });
        // get all languages
        this.subscriptionLang = this.http
            .get("dropdown/language", 1)
            .subscribe(function (httpresponse) {
            _this.languagesData = httpresponse.json();
        });
        // declaration formBuilder and all his attrib
        this.wineForm = this.fb.group({
            type: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            area_id: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            category_id: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            winery_id: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            harvest_year: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            alcohol: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            serving_temp: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            background: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            items: this.fb.array([]),
            languages: [""]
        });
    };
    // on uploading image 
    AddComponent.prototype.onUploadWineImage = function (event) {
        var file = event.target.files[0];
        if (file.type.indexOf('image') == -1) {
            this.alert.showNotification('Fajl nije slika! molimo ubacite sliku', 'danger', '');
            this.isFormValid = false;
            return false;
        }
        if (!this.validateImage(file.name)) {
            this.alert.showNotification('Format slike nije podrzan! podrzani formati: *jpg *jpeg *png', 'danger', '');
            this.isFormValid = false;
            return false;
        }
        else {
            this.isFormValid = true;
            this.wineImage = event.target.files[0];
        }
    };
    // func for validation uploaded image
    AddComponent.prototype.validateImage = function (name) {
        var ext = name.substring(name.lastIndexOf('.') + 1);
        if (ext.toLowerCase() == 'png') {
            return true;
        }
        if (ext.toLowerCase() == 'jpg') {
            return true;
        }
        if (ext.toLowerCase() == 'jpeg') {
            return true;
        }
        return false;
    };
    // removing selected language description and name from array / display
    AddComponent.prototype.onRemoveLangs = function (languageName, languageId, index) {
        var _this = this;
        var selected = this.wineForm.get("items");
        swal({
            title: "Da li ste sigurni da \u017Eelite da uklonite " + languageName + " jezik",
            text: "Vrednosti polja biće trajno obrisane!",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "NE",
            confirmButtonClass: "btn btn-success",
            cancelButtonClass: "btn btn-danger",
            confirmButtonText: "Da, obriši!",
            buttonsStyling: false
        }).then(function () {
            swal({
                title: "Obrisano!",
                text: languageName + " jezik je uspesno obrisan!",
                type: "success",
                confirmButtonClass: "btn btn-success",
                buttonsStyling: false
            });
            selected.removeAt(index);
            var renewLang = {
                name: languageName,
                id: languageId
            };
            _this.languagesData.push(renewLang);
        }, function (error) {
            _this.alert.showNotification("Greska! jezik nije obrisan ", "danger", "error");
        });
    };
    // function for creating interface for FormArray items
    AddComponent.prototype.createLanguage = function (languageId, languageName) {
        return this.fb.group({
            wineName: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            wineDesc: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            language_id: [languageId],
            language_name: [languageName]
        });
    };
    // function for adding new language in FormArray
    AddComponent.prototype.addItem = function (value) {
        var items = this.wineForm.get("items");
        items.push(this.createLanguage(value.id, value.name));
        var index = this.languagesData.indexOf(value, 0);
        this.languagesData.splice(index, 1);
    };
    AddComponent.prototype.resetForm = function () {
        this.myNgForm.resetForm();
    };
    // submitting form 
    AddComponent.prototype.onSubmit = function () {
        var _this = this;
        var fd = new FormData();
        var langForm = this.wineForm.get('items');
        var languages = [];
        langForm.controls.forEach(function (element) {
            var formGroup = element;
            languages.push({
                language_id: formGroup.controls.language_id.value,
                name: "description",
                value: formGroup.controls["wineDesc"].value
            });
            languages.push({
                language_id: formGroup.controls.language_id.value,
                name: "name",
                value: formGroup.controls["wineName"].value
            });
        });
        this.wineForm.controls.languages.setValue(languages);
        var formInput = this.wineForm.value;
        delete formInput.items;
        if (this.wineImage !== undefined) {
            fd.append("bottle", this.wineImage);
        }
        fd.append("json", JSON.stringify(formInput));
        if (this.isFormValid) {
            this.http.postFormData("create/wine", fd).subscribe(function (httpResponse) {
                if (httpResponse.status === 201) {
                    var controls = _this.wineForm.get('items');
                    while (controls.length !== 0) {
                        controls.removeAt(0);
                    }
                    _this.http.get('dropdown/language', 1).subscribe(function (lang) {
                        _this.languagesData = lang.json();
                    });
                    _this.wineImage = null;
                    languages = [];
                    _this.bottlePath.nativeElement.click();
                    _this.resetForm();
                    _this.alert.showNotification("Uspesno ste kreirali vino!", "success", "notification");
                }
            }, function (error) {
                _this.alert.showNotification("Greska, neuspesno kreiranje vina molimo proverite podatke!", "danger", "error");
            });
        }
        else {
            this.alert.showNotification('Greska slika nije odgovarajuceg formata, molimo proverite!', 'danger', '');
        }
    };
    // destroying all subscriptions
    AddComponent.prototype.ngOnDestroy = function () {
        this.subscriptionArea.unsubscribe();
        this.subscriptionCategory.unsubscribe();
        this.subscriptionWinery.unsubscribe();
        this.subscriptionLang.unsubscribe();
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])('f'),
        __metadata("design:type", Object)
    ], AddComponent.prototype, "myNgForm", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])('bottleImage'),
        __metadata("design:type", Object)
    ], AddComponent.prototype, "bottlePath", void 0);
    AddComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: "app-add",
            template: __webpack_require__("./src/app/wines/add/add.component.html"),
            styles: [__webpack_require__("./src/app/wines/add/add.component.css")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["b" /* FormBuilder */], __WEBPACK_IMPORTED_MODULE_2__services_http_service__["a" /* HttpService */], __WEBPACK_IMPORTED_MODULE_3__notifications_notifications_service__["a" /* NotificationsService */]])
    ], AddComponent);
    return AddComponent;
}());



/***/ }),

/***/ "./src/app/wines/edit/edit.component.css":
/***/ (function(module, exports) {

module.exports = ".form-full-width {\r\n    width: 100%;\r\n}\r\n\r\n#langDropdown {\r\n    margin-top: -10px;\r\n    position: absolute;\r\n    width: 100%;\r\n}\r\n\r\ni.fcancel.material-icons {\r\n    cursor: pointer;\r\n}\r\n\r\nul.dropdown-menu.dropdown-menu-left {\r\n    cursor: pointer;\r\n}\r\n\r\n#card-wine {\r\n    margin-top: 45px;\r\n}\r\n\r\n.image-tag {\r\n    font-size: 26px;\r\n}"

/***/ }),

/***/ "./src/app/wines/edit/edit.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"main-content\">\r\n    <div class=\"container-fluid\">\r\n        <div class=\"row\">\r\n            <form [formGroup]=\"wineForm\" novalidate (ngSubmit)=\"onSubmit()\">\r\n                <div class=\"col-md-offset-1 col-md-10\">\r\n                    <div formArrayName=\"items\" *ngFor=\"let item of wineForm.get('items').controls; let i = index;\">\r\n                        <div [formGroupName]=\"i\">\r\n                            <div class=\"col-md-12\">\r\n                                <div class=\"row\">\r\n                                    <div class=\"card\">\r\n                                        <div class=\"card-header card-header-icon\" data-background-color=\"darkred\">\r\n                                            <i class=\"material-icons\">language</i>\r\n                                        </div>\r\n                                        <div class=\"pull-right remove-btn\">\r\n                                            <h4 class=\"card-title\"><i (click)=\"onRemoveLangs(item.controls.language_name.value , item.controls.language_id.value ,  i)\" class=\"fcancel material-icons\">cancel</i></h4>\r\n                                        </div>\r\n                                        <div class=\"card-content\">\r\n                                            <h4 class=\"card-title\">{{item.controls['language_name'].value}}</h4>\r\n                                            <div class=\"col-md-offset-1 col-md-10\">\r\n                                                <div class=\"row\">\r\n                                                    <mat-form-field class=\"form-full-width\">\r\n                                                        <mat-label>Naziv vina</mat-label>\r\n                                                        <input (change)=\"unsave()\" matInput placeholder=\"Naziv\" formControlName=\"wineName\">\r\n                                                        <mat-error>\r\n                                                            <span *ngIf=\"item.controls['wineName'].touched && item.controls['wineName'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                                        </mat-error>\r\n                                                    </mat-form-field>\r\n                                                </div>\r\n                                                <div class=\"row \">\r\n                                                    <mat-form-field class=\"form-full-width\">\r\n                                                        <mat-label>Opis vina</mat-label>\r\n                                                        <textarea matInput (change)=\"unsave()\" placeholder=\"Opis...\" rows=\"5\" formControlName=\"wineDesc\"></textarea>\r\n                                                        <mat-error>\r\n                                                            <span *ngIf=\"item.controls['wineDesc'].touched && item.controls['wineDesc'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                                        </mat-error>\r\n                                                    </mat-form-field>\r\n                                                    <div class=\"row\">\r\n                                                        <button type=\"button\" *ngIf=\"item.controls['flag'].value == 1\" (click)=\"onSaveLanguage(item)\" class=\"btn btn-rose btn-fill btn-wd pull-right\" [disabled]=\"!item.valid || saved\">SAČUVAJ JEZIK</button>\r\n                                                    </div>\r\n                                                    <div id=\"langDropdown\" class=\"dropdown\" *ngIf=\"wineForm.get('items').controls.length == i+1 && languagesData.length !== 0\">\r\n                                                        <button class=\"dropdown-toggle btn btn-rose btn-block\" data-toggle=\"dropdown\">dodaj jezik<b class=\"caret\"></b></button>\r\n                                                        <ul class=\"dropdown-menu dropdown-menu-left\">\r\n                                                            <li class=\"dropdown-header\">izaberi jezik</li>\r\n                                                            <li *ngFor=\"let lang of languagesData\">\r\n                                                                <a (click)=\"addItem(lang)\">{{ lang.name }}</a>\r\n                                                            </li>\r\n                                                        </ul>\r\n                                                    </div>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"col-md-12\">\r\n                        <div class=\"row\">\r\n                            <div class=\"dropdown\" *ngIf=\"wineForm.get('items').controls.length == 0\">\r\n                                <button class=\"dropdown-toggle btn btn-rose btn-block\" data-toggle=\"dropdown\">dodaj jezik<b class=\"caret\"></b></button>\r\n                                <ul class=\"dropdown-menu dropdown-menu-left\">\r\n                                    <li class=\"dropdown-header\">izaberi jezik</li>\r\n                                    <li *ngFor=\"let lang of languagesData\">\r\n                                        <a (click)=\"addItem(lang)\">{{ lang.name }}</a>\r\n                                    </li>\r\n                                </ul>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                    <div id=\"card-wine\" class=\"card\">\r\n                        <div class=\"card-header card-header-icon\" data-background-color=\"darkred\">\r\n                            <i class=\"material-icons\">assignment</i>\r\n                        </div>\r\n                        <div class=\"card-content\">\r\n                            <h4 class=\"card-title\">Forma za dodavanje vina</h4>\r\n                            <div class=\"row\">\r\n                                <div class=\"col-md-3\">\r\n                                    <div class=\"pull-left\">\r\n                                        <legend>Primer</legend>\r\n                                    </div>\r\n                                    <div class=\"fileinput fileinput-new text-center\" data-provides=\"fileinput\">\r\n                                        <div class=\"fileinput-new thumbnail\">\r\n                                            <img src=\"./assets/img/placeholder-177x600.png\" alt=\"...\">\r\n                                        </div>\r\n                                        <label class=\"image-tag\">177x600</label>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"col-md-3\">\r\n                                    <div class=\"pull-left\">\r\n                                        <legend>Slika flaše</legend>\r\n                                    </div>\r\n                                    <div class=\"fileinput fileinput-new text-center\" data-provides=\"fileinput\">\r\n                                        <div class=\"fileinput-new thumbnail\">\r\n                                            <img *ngIf=\"bottleImage !== null\" [src]=\"bottleImage\" alt=\"...\">\r\n                                        </div>\r\n                                        <div class=\"fileinput-preview fileinput-exists thumbnail\"></div>\r\n                                        <div>\r\n                                            <span class=\"btn btn-rose btn-block btn-file\">\r\n                                            <span class=\"fileinput-new\">Izaberi sliku flaše</span>\r\n                                            <span class=\"fileinput-exists\">Promeni</span>\r\n                                            <input (change)=\"onUploadWineImage($event)\" type=\"file\" name=\"logo_image\" />\r\n                                            </span>\r\n                                            <a href=\"#\" #bottlePath class=\"btn btn-danger btn-round fileinput-exists\" data-dismiss=\"fileinput\"><i class=\"fa fa-times\"></i>Ukloni</a>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"col-md-6\">\r\n                                    <ul>\r\n                                        <li><strong>OBAVEŠTENJE! Odaberite da li želite da postavite pozadinu za sliku vina</strong></li>\r\n                                        <ul>\r\n                                            <li><strong>(postavi pozadinu) izaberite ukoliko je slika *jpg *jpeg formata, odnosno nema transparentu pozadinu</strong></li>\r\n                                        </ul>\r\n                                        <li><strong>OBAVEŠTENJE! Slika mora biti rezolucije 177 x 600 zbog adekvatnog prikaza u Android Aplikaciji</strong></li>\r\n                                    </ul>\r\n                                    <div class=\"checkbox-radios pull-left\">\r\n                                        <div class=\"radio\">\r\n                                            <mat-radio-group formControlName=\"background\" [value]=\"wineForm.controls['background'].value\">\r\n                                                <mat-radio-button [value]=\"1\"><strong>Postavi pozadinu</strong></mat-radio-button><br/>\r\n                                                <mat-radio-button [value]=\"0\"><strong>Ukloni pozadinu</strong></mat-radio-button>\r\n                                            </mat-radio-group>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"card\">\r\n                        <div class=\"card-content\">\r\n                            <div class=\"col-md-12\">\r\n                                <div class=\"row\">\r\n                                    <mat-form-field class=\"form-full-width\">\r\n                                        <mat-label>Sorta vina</mat-label>\r\n                                        <input matInput placeholder=\"Sorta\" formControlName=\"type\">\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['type'].touched && wineForm.controls['type'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"row\">\r\n                                <div class=\"col-md-4\">\r\n                                    <mat-form-field class=\"form-full-width\">\r\n                                        <mat-label>Kategorija vina</mat-label>\r\n                                        <mat-select formControlName=\"category_id\" [value]=\"wineForm.controls['category_id'].value\" placeholder=\"Kategorija\">\r\n                                            <mat-option *ngFor=\"let category of categories\" [value]=\"category.id\">{{category.name}}</mat-option>\r\n                                        </mat-select>\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['category_id'].touched && wineForm.controls['category_id'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                                <div class=\"col-md-4\">\r\n                                    <mat-form-field class=\"form-full-width\">\r\n                                        <mat-label>Regija</mat-label>\r\n                                        <mat-select formControlName=\"area_id\" [value]=\"wineForm.controls['area_id'].value\" placeholder=\"Regija\">\r\n                                            <mat-option *ngFor=\"let area of areas\" [value]=\"area.id\">{{area.name}}</mat-option>\r\n                                        </mat-select>\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['area_id'].touched && wineForm.controls['area_id'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                                <div class=\"col-md-4\">\r\n                                    <mat-form-field class=\"form-full-width\">\r\n                                        <mat-label>Vinarija</mat-label>\r\n                                        <mat-select formControlName=\"winery_id\" [value]=\"wineForm.controls['winery_id'].value\" placeholder=\"Vinarija\">\r\n                                            <mat-option *ngFor=\"let winery of wineryList\" [value]=\"winery.id\">{{winery.name}}</mat-option>\r\n                                        </mat-select>\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['winery_id'].touched && wineForm.controls['winery_id'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"row\">\r\n                                <div class=\"col-md-4\">\r\n                                    <mat-form-field class=\"form-full-width\">\r\n                                        <mat-label>Godina berbe</mat-label>\r\n                                        <input matInput type=\"number\" placeholder=\"Godina\" formControlName=\"harvest_year\">\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['harvest_year'].touched && wineForm.controls['harvest_year'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                                <div class=\"col-md-4\">\r\n                                    <mat-form-field class=\"form-full-width\">\r\n                                        <mat-label>Alkohol</mat-label>\r\n                                        <input matInput type=\"number\" placeholder=\"Alkohol &#37;\" formControlName=\"alcohol\">\r\n                                        <span matSuffix>&#37;</span>\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['alcohol'].touched && wineForm.controls['alcohol'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                                <div class=\"col-md-4\">\r\n                                    <mat-form-field class=\"form-full-width\">\r\n                                        <mat-label>Temperatura serviranja</mat-label>\r\n                                        <input matInput type=\"number\" placeholder=\"Temperatura u &#8451;\" formControlName=\"serving_temp\">\r\n                                        <span matSuffix>&#8451;</span>\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineForm.controls['serving_temp'].touched && wineForm.controls['serving_temp'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"row\">\r\n                                <div class=\"text-center\">\r\n                                    <button type=\"submit\" class=\"btn btn-rose btn-fill btn-wd\" [disabled]=\"!wineForm.valid\">SAČUVAJ</button>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>\r\n</div>"

/***/ }),

/***/ "./src/app/wines/edit/edit.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export MyErrorStateMatcher */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return EditComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__services_http_service__ = __webpack_require__("./src/app/services/http.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__notifications_notifications_service__ = __webpack_require__("./src/app/notifications/notifications.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





/** Error when invalid control is dirty, touched, or submitted. */
var MyErrorStateMatcher = /** @class */ (function () {
    function MyErrorStateMatcher() {
    }
    MyErrorStateMatcher.prototype.isErrorState = function (control, form) {
        var isSubmitted = form && form.submitted;
        return !!(control && control.invalid && (control.dirty || control.touched || isSubmitted));
    };
    return MyErrorStateMatcher;
}());

var EditComponent = /** @class */ (function () {
    function EditComponent(fb, http, alert, route) {
        this.fb = fb;
        this.http = http;
        this.alert = alert;
        this.route = route;
        this.categories = []; // storage result of get request for list of categories
        this.areas = []; // storage result of get request for list of areas
        this.wineryList = []; // storage result of get request for list of wineries
        this.languagesData = []; // storage result of all languages
        this.matcher = new MyErrorStateMatcher(); // error message for Angular Material Inputs
        this.bottleImage = null; // image
        this.saved = false; // language saved
    }
    EditComponent.prototype.ngOnInit = function () {
        var _this = this;
        // get get url params for wine ID
        this.subscriptionParams = this.route.params.subscribe(function (params) { return (_this.id = params.id); });
        // get all categories
        this.subscriptionCategory = this.http
            .get("dropdown/category", 1)
            .subscribe(function (httpResponse) {
            _this.categories = httpResponse.json();
        });
        // get all areas
        this.subscriptionArea = this.http
            .get("dropdown/area", 1)
            .subscribe(function (httpresponse) {
            _this.areas = httpresponse.json();
        });
        // get all wineries
        this.subscriptionWinery = this.http
            .get("dropdown/winery", 1)
            .subscribe(function (httpresponse) {
            _this.wineryList = httpresponse.json();
        });
        // get all languages
        this.subscriptionLang = this.http
            .get("dropdown/language", 1)
            .subscribe(function (httpresponse) {
            _this.languagesData = httpresponse.json();
        });
        this.initLoadingData();
        // declaration formBuilder and all his attrib
        this.wineForm = this.fb.group({
            type: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            area_id: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            category_id: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            winery_id: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            harvest_year: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            alcohol: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            serving_temp: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            background: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            items: this.fb.array([]),
            languages: [""]
        });
    };
    // get all data from server to set it on form
    EditComponent.prototype.initLoadingData = function (onSave) {
        var _this = this;
        if (onSave === void 0) { onSave = false; }
        this.subscriptionData = this.http
            .get("patch/initialize/wine/" + this.id, 1)
            .subscribe(function (httpResponse) {
            if (httpResponse.status === 200) {
                var serverData = (_this.serverData = httpResponse.json());
                _this.wineForm.controls.type.setValue(_this.serverData.type);
                _this.wineForm.controls.area_id.setValue(_this.serverData.area_id);
                _this.wineForm.controls.background.setValue(_this.serverData.background);
                _this.wineForm.controls.harvest_year.setValue(_this.serverData.harvest_year);
                _this.wineForm.controls.alcohol.setValue(_this.serverData.alcohol);
                _this.wineForm.controls.winery_id.setValue(_this.serverData.winery.id);
                _this.wineForm.controls.category_id.setValue(_this.serverData.category.id);
                _this.wineForm.controls.serving_temp.setValue(_this.serverData.serving_temp);
                _this.bottleImage = _this.serverData.bottle_image;
                serverData.languages.forEach(function (lang, langIndex) {
                    var name = "";
                    var desc = "";
                    var fieldsindex;
                    var name_id;
                    var desc_id;
                    lang.fields.forEach(function (field, fieldIndex) {
                        fieldsindex = fieldIndex;
                        if (field.name === "name") {
                            name = field.value;
                            name_id = field.id;
                        }
                        if (field.name === "description") {
                            desc = field.value;
                            desc_id = field.id;
                        }
                    });
                    if (!onSave) {
                        var index = _this.languagesData.findIndex(function (item) { return item.name === lang.language; }); // SELECTING INDEX OF OBJECT IN ARRAY BY PROPERTY *(etc. name)
                        _this.languagesData.splice(index, 1);
                    }
                    var language_name = lang.language;
                    var language_id = lang.language_id;
                    _this.createItem(name_id, desc_id, name, desc, language_name, language_id, false);
                });
            }
        }, function (error) {
        });
    };
    // creating new formGroup for languages inputs
    EditComponent.prototype.createLanguage = function (nameId, descId, wName, wDesc, lName, lId, isNew) {
        if (isNew === void 0) { isNew = true; }
        var fg = this.fb.group({
            wineName: [wName, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            wineDesc: [wDesc, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            name_id: nameId,
            desc_id: descId,
            language_name: [lName],
            language_id: [lId],
            flag: ['']
        });
        if (isNew)
            fg.controls['flag'].setValue(1);
        return fg;
    };
    // adding new item to FormArray items and splice item from langsArray
    EditComponent.prototype.addItem = function (value) {
        var isSaved;
        var items = this.wineForm.get("items");
        items.controls.forEach(function (item) {
            var items = item;
            if (items.controls.flag.value === 1) {
                isSaved = true;
                swal({
                    title: "Upozorenje! Molimo Vas da sačuvate predhodni jezik!",
                    buttonsStyling: false,
                    confirmButtonClass: "btn btn-success"
                });
                return;
            }
            isSaved = false;
        });
        if (!isSaved) {
            items.push(this.createLanguage(value.id, null, "", "", value.name, value.id));
            var index = this.languagesData.indexOf(value, 0);
            this.languagesData.splice(index, 1);
        }
    };
    // remove all from items formArray
    EditComponent.prototype.removeItem = function () {
        var controls = this.wineForm.get('items');
        while (controls.length !== 0) {
            controls.removeAt(0);
        }
    };
    // generating new languages with data from server
    EditComponent.prototype.createItem = function (nameId, descId, wName, wDesc, lname, lid, isNew) {
        if (isNew === void 0) { isNew = true; }
        var items = this.wineForm.get("items");
        items.push(this.createLanguage(nameId, descId, wName, wDesc, lname, lid, isNew));
    };
    // saving when add new language
    EditComponent.prototype.onSaveLanguage = function (value) {
        var _this = this;
        var languageFormFields = [];
        languageFormFields.push({
            language_id: value.controls.name_id.value,
            name: "description",
            value: value.controls.wineDesc.value
        });
        languageFormFields.push({
            language_id: value.controls.name_id.value,
            name: "name",
            value: value.controls.wineName.value
        });
        var postData = {
            languages: languageFormFields
        };
        this.http
            .post("add/language/wine/" + this.id, postData)
            .subscribe(function (httpResponse) {
            if (httpResponse.status === 204) {
                var itemArray = _this.wineForm.controls['items'];
                itemArray.controls.forEach(function (element) {
                    element.markAsUntouched;
                });
                _this.alert.showNotification("uspesno ste sacuvali jezik", "success", "notifications");
                _this.removeItem();
                _this.initLoadingData(true);
            }
        });
    };
    // uploading picture of wine
    EditComponent.prototype.onUploadWineImage = function (event) {
        this.uploadedImage = event.target.files[0];
    };
    // removing language form
    EditComponent.prototype.onRemoveLangs = function (language_name, language_id, index) {
        var _this = this;
        var selected = this.wineForm.get("items");
        swal({
            title: "Da li ste sigurni da \u017Eelite da uklonite " + language_name + " jezik",
            text: "Vrednosti polja biće trajno obrisane!",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: 'ne',
            confirmButtonClass: "btn btn-success",
            cancelButtonClass: "btn btn-danger",
            confirmButtonText: "Da, obriši!",
            buttonsStyling: false
        }).then(function () {
            _this.http
                .delete("delete/language/wine/" + _this.id + "/" + language_id)
                .subscribe(function (httpResponse) {
                if (httpResponse.status === 204) {
                    swal({
                        title: "Obrisano!",
                        text: language_name + " jezik je uspesno obrisan!",
                        type: "success",
                        confirmButtonClass: "btn btn-success",
                        buttonsStyling: false
                    });
                    selected.removeAt(index);
                    var renewLang = {
                        name: language_name,
                        id: language_id
                    };
                    _this.languagesData.push(renewLang);
                }
                else if (httpResponse.status !== 204) {
                    _this.alert.showNotification('neuspelo brisanje jezika', 'danger', 'notifications');
                }
            }, function (error) {
                _this.alert.showNotification("Desila se greska " + language_name + " jezik nije obrisan!, pokusajte kasnije", 'danger', '');
            });
        }, function (dismiss) {
        });
    };
    EditComponent.prototype.unsave = function () {
        this.saved = false;
    };
    // submitting form
    EditComponent.prototype.onSubmit = function () {
        var _this = this;
        var fd = new FormData();
        var languages = [];
        var langForm = this.wineForm.get('items');
        // parse data from FormArray items to this.language array
        langForm.controls.forEach(function (element) {
            var formGroup = element;
            languages.push({
                id: formGroup.controls.desc_id.value,
                name: "description",
                value: formGroup.controls["wineDesc"].value
            });
            languages.push({
                id: formGroup.controls.name_id.value,
                name: "name",
                value: formGroup.controls["wineName"].value
            });
        });
        this.wineForm.controls.languages.setValue(languages);
        var formInput = this.wineForm.value;
        delete formInput.items;
        if (this.uploadedImage !== undefined) {
            fd.append("bottle", this.uploadedImage);
        }
        fd.append("json", JSON.stringify(formInput));
        this.http.postFormData("patch/wine/" + this.id, fd).subscribe(function (httpResponse) {
            //   if (event.type === HttpEventType.UploadProgress) {
            //     console.log(
            //       "Upload progress:" +
            //         Math.round(event.loaded / event.total * 100) +
            //         "%"
            //     )
            //     console.log(event);
            //   }
            if (httpResponse.status === 204) {
                _this.removeItem();
                _this.initLoadingData(true);
                _this.alert.showNotification("Uspesno ste izmenili podatke!", "success", "notification");
            }
        }, function (error) {
            _this.alert.showNotification("Greska , niste uspesno sacuvali podatke!", "danger", "error");
        });
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])('bottlePath'),
        __metadata("design:type", Object)
    ], EditComponent.prototype, "bottlePath", void 0);
    EditComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: "app-edit",
            template: __webpack_require__("./src/app/wines/edit/edit.component.html"),
            styles: [__webpack_require__("./src/app/wines/edit/edit.component.css")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["b" /* FormBuilder */],
            __WEBPACK_IMPORTED_MODULE_2__services_http_service__["a" /* HttpService */],
            __WEBPACK_IMPORTED_MODULE_3__notifications_notifications_service__["a" /* NotificationsService */],
            __WEBPACK_IMPORTED_MODULE_4__angular_router__["a" /* ActivatedRoute */]])
    ], EditComponent);
    return EditComponent;
}());



/***/ }),

/***/ "./src/app/wines/wines.component.css":
/***/ (function(module, exports) {

module.exports = ".loading_spinner {\r\n    position: absolute;\r\n    margin-left: 50%;\r\n    margin-top: 70px;\r\n}"

/***/ }),

/***/ "./src/app/wines/wines.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"main-content\">\r\n    <div class=\"container-fluid\">\r\n        <div class=\"row\">\r\n            <div class=\"col-md-12\">\r\n                <div class=\"col-md-1 col-md-offset-11\">\r\n                    <button (click)=\"OnAddWine()\" class=\"btn btn-rose btn-lg\">DODAJ</button>\r\n                </div>\r\n                <div class=\"card\">\r\n                    <div class=\"card-header card-header-icon\" data-background-color=\"darkred\">\r\n                        <i class=\"material-icons\">assignment</i>\r\n                    </div>\r\n                    <div class=\"card-content\">\r\n                        <h4 class=\"card-title\">Vina</h4>\r\n                        <div class=\"toolbar\">\r\n                            <!--        Here you can write extra buttons/actions for the toolbar              -->\r\n                            <mat-form-field class=\"form-full-width\">\r\n                                <mat-label>Izaberi jezik</mat-label>\r\n                                <mat-select [value]=\"selectedLanguage\" placeholder=\"jezik\">\r\n                                    <mat-option *ngFor=\"let language of languages\" [value]=\"language.id\" (click)=\"onChangeLanguage(language.id, language.name)\">{{language.name}}</mat-option>\r\n                                </mat-select>\r\n                            </mat-form-field>\r\n                        </div>\r\n                        <div class=\"material-datatables table-responsive\">\r\n                            <div class=\"loading_spinner\" *ngIf=\"dataSource.loading$ | async\">\r\n\r\n                                <mat-spinner [diameter]=\"40\"></mat-spinner>\r\n\r\n                            </div>\r\n                            <mat-table class=\"winery-table mat-elevation-z8\" [dataSource]=\"dataSource\" matSort matSortDisableClear>\r\n\r\n                                <ng-container matColumnDef=\"name\">\r\n\r\n                                    <mat-header-cell *matHeaderCellDef mat-sort-header>Ime</mat-header-cell>\r\n\r\n                                    <mat-cell *matCellDef=\"let element\">{{element.name}}</mat-cell>\r\n\r\n                                </ng-container>\r\n\r\n                                <ng-container matColumnDef=\"harvest_year\">\r\n\r\n                                    <mat-header-cell *matHeaderCellDef>Godina berbe</mat-header-cell>\r\n\r\n                                    <mat-cell class=\"description-cell\" *matCellDef=\"let element\">{{element.harvest_year}}</mat-cell>\r\n\r\n                                </ng-container>\r\n                                <ng-container matColumnDef=\"winery_name\">\r\n\r\n                                    <mat-header-cell *matHeaderCellDef>Ime vinarije</mat-header-cell>\r\n\r\n                                    <mat-cell class=\"description-cell\" *matCellDef=\"let element\">{{element.winery_name}}</mat-cell>\r\n\r\n                                </ng-container>\r\n                                <ng-container matColumnDef=\"actions\">\r\n\r\n                                    <mat-header-cell *matHeaderCellDef>Akcije</mat-header-cell>\r\n\r\n                                    <mat-cell class=\"actions-cell\" *matCellDef=\"let element\">\r\n                                        <button (click)=\"OnEditWine(element.id)\" type=\"button\" rel=\"tooltip\" class=\"btn btn-just-icon btn-success rounded\"><i class=\"material-icons\">edit</i></button>\r\n                                        <button (click)=\"OnDeleteWine(element.id, element.name)\" type=\"button\" rel=\"tooltip\" class=\"btn btn-just-icon btn-danger rounded\"><i class=\"material-icons\">close</i></button>\r\n                                    </mat-cell>\r\n\r\n                                </ng-container>\r\n\r\n                                <mat-header-row *matHeaderRowDef=\"displayedColumns\"></mat-header-row>\r\n\r\n                                <mat-row *matRowDef=\"let row; columns: displayedColumns\"></mat-row>\r\n\r\n                            </mat-table>\r\n\r\n                            <mat-paginator [length]=\"total\" [pageSize]=\"pageSize\"></mat-paginator>\r\n                        </div>\r\n                    </div>\r\n                    <!-- end content-->\r\n                </div>\r\n                <!--  end card  -->\r\n            </div>\r\n            <!-- end col-md-12 -->\r\n        </div>\r\n        <!-- end row -->\r\n    </div>\r\n</div>"

/***/ }),

/***/ "./src/app/wines/wines.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return WinesComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_material__ = __webpack_require__("./node_modules/@angular/material/esm5/material.es5.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_rxjs_operators__ = __webpack_require__("./node_modules/rxjs/_esm5/operators.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__notifications_notifications_service__ = __webpack_require__("./src/app/notifications/notifications.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__services_wine_datasource__ = __webpack_require__("./src/app/services/wine.datasource.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__services_http_service__ = __webpack_require__("./src/app/services/http.service.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};







var WinesComponent = /** @class */ (function () {
    function WinesComponent(router, alert, http) {
        this.router = router;
        this.alert = alert;
        this.http = http;
        this.defaultLanguage = 1;
        this.languages = [];
        this.displayedColumns = ['name', 'harvest_year', 'winery_name', 'actions'];
    }
    WinesComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.dataSource = new __WEBPACK_IMPORTED_MODULE_5__services_wine_datasource__["a" /* WineDataSource */](this.http);
        this.dataSource.loadWines(1, this.defaultLanguage);
        this.selectedLanguage = this.defaultLanguage;
        this.subscriptionLang = this.http.get("dropdown/language", 1).subscribe(function (httpResponse) {
            _this.languages = httpResponse.json();
        });
        // fetch data for table
        this.subscription = this.http
            .get("get/wine", this.selectedLanguage)
            .subscribe(function (httpResponse) {
            if (httpResponse.status === 200) {
                _this.total = httpResponse.json().total;
                _this.pageSize = httpResponse.json().per_page;
            }
        }, function (error) {
            _this.alert.showNotification('Greska na serveru, molimo pokusajte kasnije!', 'danger', '');
        });
    };
    WinesComponent.prototype.ngAfterViewInit = function () {
        var _this = this;
        this.paginator.page.pipe(Object(__WEBPACK_IMPORTED_MODULE_3_rxjs_operators__["tap"])(function () { return _this.loadWineryPage(); })).subscribe();
    };
    WinesComponent.prototype.loadWineryPage = function () {
        this.dataSource.loadWines(this.paginator.pageIndex + 1, this.selectedLanguage);
    };
    WinesComponent.prototype.onChangeLanguage = function (id, name) {
        var _this = this;
        this.selectedLanguage = id;
        this.dataSource = new __WEBPACK_IMPORTED_MODULE_5__services_wine_datasource__["a" /* WineDataSource */](this.http);
        this.dataSource.loadWines(this.paginator.pageIndex, this.selectedLanguage);
        this.paginator.firstPage();
        this.subscription = this.http
            .get("get/wine", this.selectedLanguage)
            .subscribe(function (httpResponse) {
            if (httpResponse.status === 200) {
                _this.total = httpResponse.json().total;
                _this.pageSize = httpResponse.json().per_page;
            }
        });
    };
    WinesComponent.prototype.OnAddWine = function () {
        this.router.navigate(["wines/add"]);
    };
    WinesComponent.prototype.OnEditWine = function (id) {
        this.router.navigate(["wines/edit", id]);
    };
    WinesComponent.prototype.OnDeleteWine = function (id, name) {
        var _this = this;
        swal({
            title: "Da li ste sigurni da \u017Eelite da obri\u0161ete " + name + " ?",
            text: "Podatke nije moguće povratiti nakon brisanja!",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: 'ne',
            confirmButtonClass: "btn btn-success",
            cancelButtonClass: "btn btn-danger",
            confirmButtonText: "Da, obriši!",
            buttonsStyling: false
        }).then(function () {
            _this.http.delete("delete/wine/" + id).subscribe(function (httpResponse) {
                if (httpResponse.status === 204) {
                    swal({
                        title: "Obrisano!",
                        text: "Vino " + name + " je uspesno obrisano",
                        type: "success",
                        confirmButtonClass: "btn btn-success",
                        buttonsStyling: false
                    });
                    _this.http.get('get/wine', _this.selectedLanguage).subscribe(function (data) {
                        _this.paginator.length = data.json().total;
                    });
                    _this.dataSource = new __WEBPACK_IMPORTED_MODULE_5__services_wine_datasource__["a" /* WineDataSource */](_this.http);
                    _this.dataSource.loadWines(_this.paginator.pageIndex, _this.selectedLanguage);
                    _this.paginator.firstPage();
                }
                (function (error) {
                    _this.alert.showNotification("Greska!" + name + "vino nije obrisano", "danger", "error");
                });
            });
        }, function (dismiss) {
        });
    };
    WinesComponent.prototype.ngOnDestroy = function () {
        this.subscription.unsubscribe();
        this.subscriptionLang.unsubscribe();
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])(__WEBPACK_IMPORTED_MODULE_2__angular_material__["s" /* MatPaginator */]),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_2__angular_material__["s" /* MatPaginator */])
    ], WinesComponent.prototype, "paginator", void 0);
    WinesComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'app-wines',
            template: __webpack_require__("./src/app/wines/wines.component.html"),
            styles: [__webpack_require__("./src/app/wines/wines.component.css")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__angular_router__["b" /* Router */],
            __WEBPACK_IMPORTED_MODULE_4__notifications_notifications_service__["a" /* NotificationsService */],
            __WEBPACK_IMPORTED_MODULE_6__services_http_service__["a" /* HttpService */]])
    ], WinesComponent);
    return WinesComponent;
}());



/***/ }),

/***/ "./src/app/wines/wines.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "WinesModule", function() { return WinesModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_common__ = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__wines_component__ = __webpack_require__("./src/app/wines/wines.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__wines_edit_edit_component__ = __webpack_require__("./src/app/wines/edit/edit.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__add_add_component__ = __webpack_require__("./src/app/wines/add/add.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__wines_routing__ = __webpack_require__("./src/app/wines/wines.routing.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__angular_material__ = __webpack_require__("./node_modules/@angular/material/esm5/material.es5.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};









var WinesModule = /** @class */ (function () {
    function WinesModule() {
    }
    WinesModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [
                __WEBPACK_IMPORTED_MODULE_1__angular_common__["b" /* CommonModule */],
                __WEBPACK_IMPORTED_MODULE_6__angular_router__["c" /* RouterModule */].forChild(__WEBPACK_IMPORTED_MODULE_7__wines_routing__["a" /* WinesTable */]),
                __WEBPACK_IMPORTED_MODULE_5__angular_forms__["e" /* FormsModule */],
                __WEBPACK_IMPORTED_MODULE_5__angular_forms__["k" /* ReactiveFormsModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["w" /* MatRadioModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["a" /* MatAutocompleteModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["b" /* MatButtonModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["c" /* MatButtonToggleModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["d" /* MatCardModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["e" /* MatCheckboxModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["f" /* MatChipsModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["E" /* MatStepperModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["h" /* MatDatepickerModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["i" /* MatDialogModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["j" /* MatDividerModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["k" /* MatExpansionModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["m" /* MatGridListModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["n" /* MatIconModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["o" /* MatInputModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["p" /* MatListModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["q" /* MatMenuModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["r" /* MatNativeDateModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["t" /* MatPaginatorModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["u" /* MatProgressBarModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["v" /* MatProgressSpinnerModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["w" /* MatRadioModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["x" /* MatRippleModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["y" /* MatSelectModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["z" /* MatSidenavModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["B" /* MatSliderModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["A" /* MatSlideToggleModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["C" /* MatSnackBarModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["D" /* MatSortModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["F" /* MatTableModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["G" /* MatTabsModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["H" /* MatToolbarModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["I" /* MatTooltipModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["l" /* MatFormFieldModule */]
            ],
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__wines_component__["a" /* WinesComponent */],
                __WEBPACK_IMPORTED_MODULE_3__wines_edit_edit_component__["a" /* EditComponent */],
                __WEBPACK_IMPORTED_MODULE_4__add_add_component__["a" /* AddComponent */]
            ],
            exports: [
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["l" /* MatFormFieldModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["a" /* MatAutocompleteModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["b" /* MatButtonModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["c" /* MatButtonToggleModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["d" /* MatCardModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["e" /* MatCheckboxModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["f" /* MatChipsModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["E" /* MatStepperModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["h" /* MatDatepickerModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["i" /* MatDialogModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["j" /* MatDividerModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["k" /* MatExpansionModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["m" /* MatGridListModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["n" /* MatIconModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["o" /* MatInputModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["p" /* MatListModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["q" /* MatMenuModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["r" /* MatNativeDateModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["t" /* MatPaginatorModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["u" /* MatProgressBarModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["v" /* MatProgressSpinnerModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["w" /* MatRadioModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["x" /* MatRippleModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["y" /* MatSelectModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["z" /* MatSidenavModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["B" /* MatSliderModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["A" /* MatSlideToggleModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["C" /* MatSnackBarModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["D" /* MatSortModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["F" /* MatTableModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["G" /* MatTabsModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["H" /* MatToolbarModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["I" /* MatTooltipModule */]
            ]
        })
    ], WinesModule);
    return WinesModule;
}());



/***/ }),

/***/ "./src/app/wines/wines.routing.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return WinesTable; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__wines_component__ = __webpack_require__("./src/app/wines/wines.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__edit_edit_component__ = __webpack_require__("./src/app/wines/edit/edit.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__add_add_component__ = __webpack_require__("./src/app/wines/add/add.component.ts");



var WinesTable = [
    {
        path: '',
        children: [{
                path: '',
                component: __WEBPACK_IMPORTED_MODULE_0__wines_component__["a" /* WinesComponent */]
            }]
    }, {
        path: '',
        children: [{
                path: 'edit/:id',
                component: __WEBPACK_IMPORTED_MODULE_1__edit_edit_component__["a" /* EditComponent */],
                pathMatch: 'full'
            }]
    }, {
        path: '',
        children: [{
                path: 'add',
                component: __WEBPACK_IMPORTED_MODULE_2__add_add_component__["a" /* AddComponent */],
                pathMatch: 'full'
            }]
    }
];


/***/ })

});
//# sourceMappingURL=wines.module.chunk.js.map