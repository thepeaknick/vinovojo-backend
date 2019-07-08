webpackJsonp(["users.module"],{

/***/ "./node_modules/ng4-validators/ng4-validators.es5.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return CustomValidators; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return CustomFormsModule; });
/* unused harmony export ɵba */
/* unused harmony export ɵa */
/* unused harmony export ɵbb */
/* unused harmony export ɵb */
/* unused harmony export ɵbc */
/* unused harmony export ɵc */
/* unused harmony export ɵbe */
/* unused harmony export ɵe */
/* unused harmony export ɵbd */
/* unused harmony export ɵd */
/* unused harmony export ɵbf */
/* unused harmony export ɵf */
/* unused harmony export ɵbg */
/* unused harmony export ɵg */
/* unused harmony export ɵbi */
/* unused harmony export ɵi */
/* unused harmony export ɵbh */
/* unused harmony export ɵh */
/* unused harmony export ɵbk */
/* unused harmony export ɵk */
/* unused harmony export ɵbj */
/* unused harmony export ɵj */
/* unused harmony export ɵbl */
/* unused harmony export ɵl */
/* unused harmony export ɵbn */
/* unused harmony export ɵn */
/* unused harmony export ɵbm */
/* unused harmony export ɵm */
/* unused harmony export ɵbp */
/* unused harmony export ɵp */
/* unused harmony export ɵbo */
/* unused harmony export ɵo */
/* unused harmony export ɵbr */
/* unused harmony export ɵr */
/* unused harmony export ɵbq */
/* unused harmony export ɵq */
/* unused harmony export ɵbt */
/* unused harmony export ɵt */
/* unused harmony export ɵbs */
/* unused harmony export ɵs */
/* unused harmony export ɵbu */
/* unused harmony export ɵu */
/* unused harmony export ɵbv */
/* unused harmony export ɵv */
/* unused harmony export ɵbx */
/* unused harmony export ɵx */
/* unused harmony export ɵbw */
/* unused harmony export ɵw */
/* unused harmony export ɵby */
/* unused harmony export ɵy */
/* unused harmony export ɵbz */
/* unused harmony export ɵz */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");


/**
 * @param {?} obj
 * @return {?}
 */
function isPresent(obj) {
    return obj !== undefined && obj !== null;
}
/**
 * @param {?} obj
 * @return {?}
 */
function isDate(obj) {
    return !/Invalid|NaN/.test(new Date(obj).toString());
}
/**
 * @param {?} obj
 * @return {?}
 */
function parseDate(obj) {
    try {
        if (typeof obj === 'object' && obj.year != null && obj.month != null && obj.day != null) {
            return obj.year + '-' + obj.month + '-' + obj.day;
        }
    }
    catch (e) { }
    return obj;
}
var arrayLength = function (value) {
    return function (control) {
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ obj = control.value;
        return Array.isArray(obj) && obj.length >= +value ? null : { arrayLength: +value };
    };
};
var base64 = function (control) {
    if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
        return null;
    }
    var /** @type {?} */ v = control.value;
    return /^(?:[A-Z0-9+\/]{4})*(?:[A-Z0-9+\/]{2}==|[A-Z0-9+\/]{3}=|[A-Z0-9+\/]{4})$/i.test(v) ? null : { 'base64': true };
};
var creditCard = function (control) {
    if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
        return null;
    }
    var /** @type {?} */ v = control.value;
    var /** @type {?} */ sanitized = v.replace(/[^0-9]+/g, '');
    // problem with chrome
    /* tslint:disable */
    if (!(/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11}|(?:9792)\d{12})$/.test(sanitized))) {
        return { creditCard: true };
    }
    /* tslint:enable */
    var /** @type {?} */ sum = 0;
    var /** @type {?} */ digit;
    var /** @type {?} */ tmpNum;
    var /** @type {?} */ shouldDouble;
    for (var /** @type {?} */ i = sanitized.length - 1; i >= 0; i--) {
        digit = sanitized.substring(i, (i + 1));
        tmpNum = parseInt(digit, 10);
        if (shouldDouble) {
            tmpNum *= 2;
            if (tmpNum >= 10) {
                sum += ((tmpNum % 10) + 1);
            }
            else {
                sum += tmpNum;
            }
        }
        else {
            sum += tmpNum;
        }
        shouldDouble = !shouldDouble;
    }
    if (Boolean((sum % 10) === 0 ? sanitized : false)) {
        return null;
    }
    return { creditCard: true };
};
var date = function (control) {
    if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
        return null;
    }
    var /** @type {?} */ v = control.value;
    return isDate(v) ? null : { date: true };
};
var dateISO = function (control) {
    if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
        return null;
    }
    var /** @type {?} */ v = control.value;
    return /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(v) ? null : { dateISO: true };
};
var digits = function (control) {
    if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
        return null;
    }
    var /** @type {?} */ v = control.value;
    return /^\d+$/.test(v) ? null : { digits: true };
};
var email = function (control) {
    if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
        return null;
    }
    var /** @type {?} */ v = control.value;
    /* tslint:disable */
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) ? null : { 'email': true };
    /* tslint:enable */
};
var equal = function (val) {
    return function (control) {
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ v = control.value;
        return val === v ? null : { equal: true };
    };
};
var equalTo = function (equalControl) {
    var /** @type {?} */ subscribe = false;
    return function (control) {
        if (!subscribe) {
            subscribe = true;
            equalControl.valueChanges.subscribe(function () {
                control.updateValueAndValidity();
            });
        }
        var /** @type {?} */ v = control.value;
        return equalControl.value === v ? null : { equalTo: true };
    };
};
var gt = function (value) {
    return function (control) {
        if (!isPresent(value)) {
            return null;
        }
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ v = +control.value;
        return v > +value ? null : { gt: true };
    };
};
var gte = function (value) {
    return function (control) {
        if (!isPresent(value)) {
            return null;
        }
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ v = +control.value;
        return v >= +value ? null : { gte: true };
    };
};
var json = function (control) {
    if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
        return null;
    }
    var /** @type {?} */ v = control.value;
    try {
        var /** @type {?} */ obj = JSON.parse(v);
        if (Boolean(obj) && typeof obj === 'object') {
            return null;
        }
    }
    catch (e) { }
    return { json: true };
};
var lt = function (value) {
    return function (control) {
        if (!isPresent(value)) {
            return null;
        }
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ v = +control.value;
        return v < +value ? null : { lt: true };
    };
};
var lte = function (value) {
    return function (control) {
        if (!isPresent(value)) {
            return null;
        }
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ v = +control.value;
        return v <= +value ? null : { lte: true };
    };
};
var max = function (value) {
    return function (control) {
        if (!isPresent(value)) {
            return null;
        }
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ v = +control.value;
        return v <= +value ? null : { actualValue: v, requiredValue: +value, max: true };
    };
};
var maxDate = function (maxInput) {
    var /** @type {?} */ value;
    var /** @type {?} */ subscribe = false;
    var /** @type {?} */ maxValue = maxInput;
    var /** @type {?} */ isForm = maxInput instanceof __WEBPACK_IMPORTED_MODULE_1__angular_forms__["c" /* FormControl */] || maxInput instanceof __WEBPACK_IMPORTED_MODULE_1__angular_forms__["j" /* NgModel */];
    return function (control) {
        if (!subscribe && isForm) {
            subscribe = true;
            maxInput.valueChanges.subscribe(function () {
                control.updateValueAndValidity();
            });
        }
        if (isForm) {
            maxValue = maxInput.value;
        }
        value = parseDate(maxValue);
        if (!isDate(value) && !(value instanceof Function)) {
            if (value == null) {
                return null;
            }
            else if (isForm) {
                return { maxDate: true, error: 'maxDate is invalid' };
            }
            else {
                throw Error('maxDate value must be or return a formatted date');
            }
        }
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ d = new Date(parseDate(control.value)).getTime();
        if (!isDate(d)) {
            return { value: true };
        }
        if (value instanceof Function) {
            value = value();
        }
        return d <= new Date(value).getTime() ? null : { maxDate: true, error: 'greater than maxDate' };
    };
};
var min = function (value) {
    return function (control) {
        if (!isPresent(value)) {
            return null;
        }
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ v = +control.value;
        return v >= +value ? null : { actualValue: v, requiredValue: +value, min: true };
    };
};
var minDate = function (minInput) {
    var /** @type {?} */ value;
    var /** @type {?} */ subscribe = false;
    var /** @type {?} */ minValue = minInput;
    var /** @type {?} */ isForm = minInput instanceof __WEBPACK_IMPORTED_MODULE_1__angular_forms__["c" /* FormControl */] || minInput instanceof __WEBPACK_IMPORTED_MODULE_1__angular_forms__["j" /* NgModel */];
    return function (control) {
        if (!subscribe && isForm) {
            subscribe = true;
            minInput.valueChanges.subscribe(function () {
                control.updateValueAndValidity();
            });
        }
        if (isForm) {
            minValue = minInput.value;
        }
        value = parseDate(minValue);
        if (!isDate(value) && !(value instanceof Function)) {
            if (value == null) {
                return null;
            }
            else if (isForm) {
                return { minDate: true, error: 'minDate is invalid' };
            }
            else {
                throw Error('minDate value must be or return a formatted date');
            }
        }
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ d = new Date(parseDate(control.value)).getTime();
        if (!isDate(d)) {
            return { value: true };
        }
        if (value instanceof Function) {
            value = value();
        }
        return d >= new Date(value).getTime() ? null : { minDate: true, error: 'lower than minDate' };
    };
};
var notEqual = function (val) {
    return function (control) {
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ v = control.value;
        return val !== v ? null : { notEqual: true };
    };
};
var notEqualTo = function (notEqualControl) {
    var /** @type {?} */ subscribe = false;
    return function (control) {
        if (!subscribe) {
            subscribe = true;
            notEqualControl.valueChanges.subscribe(function () {
                control.updateValueAndValidity();
            });
        }
        var /** @type {?} */ v = control.value;
        return notEqualControl.value !== v ? null : { notEqualTo: true };
    };
};
var number = function (control) {
    if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
        return null;
    }
    var /** @type {?} */ v = control.value;
    return /^(?:-?\d+|-?\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(v) ? null : { 'number': true };
};
var property = function (value) {
    return function (control) {
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ properties = value.split(',');
        var /** @type {?} */ obj = control.value;
        var /** @type {?} */ isValid = true;
        for (var _i = 0, properties_1 = properties; _i < properties_1.length; _i++) {
            var prop = properties_1[_i];
            if (obj[prop] == null) {
                isValid = false;
                break;
            }
        }
        return isValid ? null : { hasProperty: true, property: value };
    };
};
var range = function (value) {
    return function (control) {
        if (!isPresent(value)) {
            return null;
        }
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ v = +control.value;
        return v >= value[0] && v <= value[1] ? null : { actualValue: v, requiredValue: value, range: true };
    };
};
var rangeLength = function (value) {
    return function (control) {
        if (!isPresent(value)) {
            return null;
        }
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ v = control.value;
        return v.length >= value[0] && v.length <= value[1] ? null : { rangeLength: true };
    };
};
var uuids = {
    '3': /^[0-9A-F]{8}-[0-9A-F]{4}-3[0-9A-F]{3}-[0-9A-F]{4}-[0-9A-F]{12}$/i,
    '4': /^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i,
    '5': /^[0-9A-F]{8}-[0-9A-F]{4}-5[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i,
    'all': /^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$/i
};
var uuid = function (version) {
    return function (control) {
        if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
            return null;
        }
        var /** @type {?} */ v = control.value;
        var /** @type {?} */ pattern = uuids[version] || uuids.all;
        return (new RegExp(pattern)).test(v) ? null : { uuid: true };
    };
};
var url = function (control) {
    if (isPresent(__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required(control))) {
        return null;
    }
    var /** @type {?} */ v = control.value;
    /* tslint:disable */
    return /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[/?#]\S*)?$/i.test(v) ? null : { 'url': true };
    /* tslint:enable */
};
var ARRAY_LENGTH_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return ArrayLengthValidator; }),
    multi: true
};
var ArrayLengthValidator = (function () {
    function ArrayLengthValidator() {
    }
    /**
     * @return {?}
     */
    ArrayLengthValidator.prototype.ngOnInit = function () {
        this.validator = arrayLength(this.arrayLength);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    ArrayLengthValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'arrayLength') {
                this.validator = arrayLength(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    ArrayLengthValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    ArrayLengthValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return ArrayLengthValidator;
}());
ArrayLengthValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[arrayLength][formControlName],[arrayLength][formControl],[arrayLength][ngModel]',
                providers: [ARRAY_LENGTH_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
ArrayLengthValidator.ctorParameters = function () { return []; };
ArrayLengthValidator.propDecorators = {
    'arrayLength': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var BASE64_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return Base64Validator; }),
    multi: true
};
var Base64Validator = (function () {
    function Base64Validator() {
    }
    /**
     * @param {?} c
     * @return {?}
     */
    Base64Validator.prototype.validate = function (c) {
        return base64(c);
    };
    return Base64Validator;
}());
Base64Validator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[base64][formControlName],[base64][formControl],[base64][ngModel]',
                providers: [BASE64_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
Base64Validator.ctorParameters = function () { return []; };
var CREDIT_CARD_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return CreditCardValidator; }),
    multi: true
};
var CreditCardValidator = (function () {
    function CreditCardValidator() {
    }
    /**
     * @param {?} c
     * @return {?}
     */
    CreditCardValidator.prototype.validate = function (c) {
        return creditCard(c);
    };
    return CreditCardValidator;
}());
CreditCardValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[creditCard][formControlName],[creditCard][formControl],[creditCard][ngModel]',
                providers: [CREDIT_CARD_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
CreditCardValidator.ctorParameters = function () { return []; };
var DATE_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return DateValidator; }),
    multi: true
};
var DateValidator = (function () {
    function DateValidator() {
    }
    /**
     * @param {?} c
     * @return {?}
     */
    DateValidator.prototype.validate = function (c) {
        return date(c);
    };
    return DateValidator;
}());
DateValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[date][formControlName],[date][formControl],[date][ngModel]',
                providers: [DATE_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
DateValidator.ctorParameters = function () { return []; };
var DATE_ISO_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return DateISOValidator; }),
    multi: true
};
var DateISOValidator = (function () {
    function DateISOValidator() {
    }
    /**
     * @param {?} c
     * @return {?}
     */
    DateISOValidator.prototype.validate = function (c) {
        return dateISO(c);
    };
    return DateISOValidator;
}());
DateISOValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[dateISO][formControlName],[dateISO][formControl],[dateISO][ngModel]',
                providers: [DATE_ISO_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
DateISOValidator.ctorParameters = function () { return []; };
var DIGITS_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return DigitsValidator; }),
    multi: true
};
var DigitsValidator = (function () {
    function DigitsValidator() {
    }
    /**
     * @param {?} c
     * @return {?}
     */
    DigitsValidator.prototype.validate = function (c) {
        return digits(c);
    };
    return DigitsValidator;
}());
DigitsValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[digits][formControlName],[digits][formControl],[digits][ngModel]',
                providers: [DIGITS_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
DigitsValidator.ctorParameters = function () { return []; };
var EMAIL_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return EmailValidator; }),
    multi: true
};
var EmailValidator = (function () {
    function EmailValidator() {
    }
    /**
     * @param {?} c
     * @return {?}
     */
    EmailValidator.prototype.validate = function (c) {
        return email(c);
    };
    return EmailValidator;
}());
EmailValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[ngvemail][formControlName],[ngvemail][formControl],[ngvemail][ngModel]',
                providers: [EMAIL_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
EmailValidator.ctorParameters = function () { return []; };
var EQUAL_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return EqualValidator; }),
    multi: true
};
var EqualValidator = (function () {
    function EqualValidator() {
    }
    /**
     * @return {?}
     */
    EqualValidator.prototype.ngOnInit = function () {
        this.validator = equal(this.equal);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    EqualValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'equal') {
                this.validator = equal(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    EqualValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    EqualValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return EqualValidator;
}());
EqualValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[equal][formControlName],[equal][formControl],[equal][ngModel]',
                providers: [EQUAL_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
EqualValidator.ctorParameters = function () { return []; };
EqualValidator.propDecorators = {
    'equal': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var EQUAL_TO_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return EqualToValidator; }),
    multi: true
};
var EqualToValidator = (function () {
    function EqualToValidator() {
    }
    /**
     * @return {?}
     */
    EqualToValidator.prototype.ngOnInit = function () {
        this.validator = equalTo(this.equalTo);
    };
    /**
     * @param {?} c
     * @return {?}
     */
    EqualToValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    return EqualToValidator;
}());
EqualToValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[equalTo][formControlName],[equalTo][formControl],[equalTo][ngModel]',
                providers: [EQUAL_TO_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
EqualToValidator.ctorParameters = function () { return []; };
EqualToValidator.propDecorators = {
    'equalTo': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var GREATER_THAN_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return GreaterThanValidator; }),
    multi: true
};
var GreaterThanValidator = (function () {
    function GreaterThanValidator() {
    }
    /**
     * @return {?}
     */
    GreaterThanValidator.prototype.ngOnInit = function () {
        this.validator = gt(this.gt);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    GreaterThanValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'gt') {
                this.validator = gt(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    GreaterThanValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    GreaterThanValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return GreaterThanValidator;
}());
GreaterThanValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[gt][formControlName],[gt][formControl],[gt][ngModel]',
                providers: [GREATER_THAN_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
GreaterThanValidator.ctorParameters = function () { return []; };
GreaterThanValidator.propDecorators = {
    'gt': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var GREATER_THAN_EQUAL_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return GreaterThanEqualValidator; }),
    multi: true
};
var GreaterThanEqualValidator = (function () {
    function GreaterThanEqualValidator() {
    }
    /**
     * @return {?}
     */
    GreaterThanEqualValidator.prototype.ngOnInit = function () {
        this.validator = gte(this.gte);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    GreaterThanEqualValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'gte') {
                this.validator = gte(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    GreaterThanEqualValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    GreaterThanEqualValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return GreaterThanEqualValidator;
}());
GreaterThanEqualValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[gte][formControlName],[gte][formControl],[gte][ngModel]',
                providers: [GREATER_THAN_EQUAL_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
GreaterThanEqualValidator.ctorParameters = function () { return []; };
GreaterThanEqualValidator.propDecorators = {
    'gte': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var JSON_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return JSONValidator; }),
    multi: true
};
var JSONValidator = (function () {
    function JSONValidator() {
    }
    /**
     * @param {?} c
     * @return {?}
     */
    JSONValidator.prototype.validate = function (c) {
        return json(c);
    };
    return JSONValidator;
}());
JSONValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[json][formControlName],[json][formControl],[json][ngModel]',
                providers: [JSON_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
JSONValidator.ctorParameters = function () { return []; };
var LESS_THAN_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return LessThanValidator; }),
    multi: true
};
var LessThanValidator = (function () {
    function LessThanValidator() {
    }
    /**
     * @return {?}
     */
    LessThanValidator.prototype.ngOnInit = function () {
        this.validator = lt(this.lt);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    LessThanValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'lt') {
                this.validator = lt(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    LessThanValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    LessThanValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return LessThanValidator;
}());
LessThanValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[lt][formControlName],[lt][formControl],[lt][ngModel]',
                providers: [LESS_THAN_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
LessThanValidator.ctorParameters = function () { return []; };
LessThanValidator.propDecorators = {
    'lt': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var LESS_THAN_EQUAL_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return LessThanEqualValidator; }),
    multi: true
};
var LessThanEqualValidator = (function () {
    function LessThanEqualValidator() {
    }
    /**
     * @return {?}
     */
    LessThanEqualValidator.prototype.ngOnInit = function () {
        this.validator = lte(this.lte);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    LessThanEqualValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'lte') {
                this.validator = lte(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    LessThanEqualValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    LessThanEqualValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return LessThanEqualValidator;
}());
LessThanEqualValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[lte][formControlName],[lte][formControl],[lte][ngModel]',
                providers: [LESS_THAN_EQUAL_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
LessThanEqualValidator.ctorParameters = function () { return []; };
LessThanEqualValidator.propDecorators = {
    'lte': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var MAX_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return MaxValidator; }),
    multi: true
};
var MaxValidator = (function () {
    function MaxValidator() {
    }
    /**
     * @return {?}
     */
    MaxValidator.prototype.ngOnInit = function () {
        this.validator = max(this.max);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    MaxValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'max') {
                this.validator = max(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    MaxValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    MaxValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return MaxValidator;
}());
MaxValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[max][formControlName],[max][formControl],[max][ngModel]',
                providers: [MAX_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
MaxValidator.ctorParameters = function () { return []; };
MaxValidator.propDecorators = {
    'max': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var MAX_DATE_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return MaxDateValidator; }),
    multi: true
};
var MaxDateValidator = (function () {
    function MaxDateValidator() {
    }
    /**
     * @return {?}
     */
    MaxDateValidator.prototype.ngOnInit = function () {
        this.validator = maxDate(this.maxDate);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    MaxDateValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'maxDate') {
                this.validator = maxDate(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    MaxDateValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    MaxDateValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return MaxDateValidator;
}());
MaxDateValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[maxDate][formControlName],[maxDate][formControl],[maxDate][ngModel]',
                providers: [MAX_DATE_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
MaxDateValidator.ctorParameters = function () { return []; };
MaxDateValidator.propDecorators = {
    'maxDate': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var MIN_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return MinValidator; }),
    multi: true
};
var MinValidator = (function () {
    function MinValidator() {
    }
    /**
     * @return {?}
     */
    MinValidator.prototype.ngOnInit = function () {
        this.validator = min(this.min);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    MinValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'min') {
                this.validator = min(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    MinValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    MinValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return MinValidator;
}());
MinValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[min][formControlName],[min][formControl],[min][ngModel]',
                providers: [MIN_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
MinValidator.ctorParameters = function () { return []; };
MinValidator.propDecorators = {
    'min': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var MIN_DATE_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return MinDateValidator; }),
    multi: true
};
var MinDateValidator = (function () {
    function MinDateValidator() {
    }
    /**
     * @return {?}
     */
    MinDateValidator.prototype.ngOnInit = function () {
        this.validator = minDate(this.minDate);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    MinDateValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'minDate') {
                this.validator = minDate(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    MinDateValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    MinDateValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return MinDateValidator;
}());
MinDateValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[minDate][formControlName],[minDate][formControl],[minDate][ngModel]',
                providers: [MIN_DATE_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
MinDateValidator.ctorParameters = function () { return []; };
MinDateValidator.propDecorators = {
    'minDate': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var NOT_EQUAL_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return NotEqualValidator; }),
    multi: true
};
var NotEqualValidator = (function () {
    function NotEqualValidator() {
    }
    /**
     * @return {?}
     */
    NotEqualValidator.prototype.ngOnInit = function () {
        this.validator = notEqual(this.notEqual);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    NotEqualValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'notEqual') {
                this.validator = notEqual(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    NotEqualValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    NotEqualValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return NotEqualValidator;
}());
NotEqualValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[notEqual][formControlName],[notEqual][formControl],[notEqual][ngModel]',
                providers: [NOT_EQUAL_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
NotEqualValidator.ctorParameters = function () { return []; };
NotEqualValidator.propDecorators = {
    'notEqual': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var NOT_EQUAL_TO_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return NotEqualToValidator; }),
    multi: true
};
var NotEqualToValidator = (function () {
    function NotEqualToValidator() {
    }
    /**
     * @return {?}
     */
    NotEqualToValidator.prototype.ngOnInit = function () {
        this.validator = notEqualTo(this.notEqualTo);
    };
    /**
     * @param {?} c
     * @return {?}
     */
    NotEqualToValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    return NotEqualToValidator;
}());
NotEqualToValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[notEqualTo][formControlName],[notEqualTo][formControl],[notEqualTo][ngModel]',
                providers: [NOT_EQUAL_TO_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
NotEqualToValidator.ctorParameters = function () { return []; };
NotEqualToValidator.propDecorators = {
    'notEqualTo': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var NUMBER_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return NumberValidator; }),
    multi: true
};
var NumberValidator = (function () {
    function NumberValidator() {
    }
    /**
     * @param {?} c
     * @return {?}
     */
    NumberValidator.prototype.validate = function (c) {
        return number(c);
    };
    return NumberValidator;
}());
NumberValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[number][formControlName],[number][formControl],[number][ngModel]',
                providers: [NUMBER_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
NumberValidator.ctorParameters = function () { return []; };
var PROPERTY_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return PropertyValidator; }),
    multi: true
};
var PropertyValidator = (function () {
    function PropertyValidator() {
    }
    /**
     * @return {?}
     */
    PropertyValidator.prototype.ngOnInit = function () {
        this.validator = property(this.property);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    PropertyValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'property') {
                this.validator = property(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    PropertyValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    PropertyValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return PropertyValidator;
}());
PropertyValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[property][formControlName],[property][formControl],[property][ngModel]',
                providers: [PROPERTY_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
PropertyValidator.ctorParameters = function () { return []; };
PropertyValidator.propDecorators = {
    'property': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var RANGE_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return RangeValidator; }),
    multi: true
};
var RangeValidator = (function () {
    function RangeValidator() {
    }
    /**
     * @return {?}
     */
    RangeValidator.prototype.ngOnInit = function () {
        this.validator = range(this.range);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    RangeValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'range') {
                this.validator = range(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    RangeValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    RangeValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return RangeValidator;
}());
RangeValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[range][formControlName],[range][formControl],[range][ngModel]',
                providers: [RANGE_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
RangeValidator.ctorParameters = function () { return []; };
RangeValidator.propDecorators = {
    'range': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var RANGE_LENGTH_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return RangeLengthValidator; }),
    multi: true
};
var RangeLengthValidator = (function () {
    function RangeLengthValidator() {
    }
    /**
     * @return {?}
     */
    RangeLengthValidator.prototype.ngOnInit = function () {
        this.validator = rangeLength(this.rangeLength);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    RangeLengthValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'rangeLength') {
                this.validator = rangeLength(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    RangeLengthValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    RangeLengthValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return RangeLengthValidator;
}());
RangeLengthValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[rangeLength][formControlName],[rangeLength][formControl],[rangeLength][ngModel]',
                providers: [RANGE_LENGTH_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
RangeLengthValidator.ctorParameters = function () { return []; };
RangeLengthValidator.propDecorators = {
    'rangeLength': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var URL_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return UrlValidator; }),
    multi: true
};
var UrlValidator = (function () {
    function UrlValidator() {
    }
    /**
     * @param {?} c
     * @return {?}
     */
    UrlValidator.prototype.validate = function (c) {
        return url(c);
    };
    return UrlValidator;
}());
UrlValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[url][formControlName],[url][formControl],[url][ngModel]',
                providers: [URL_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
UrlValidator.ctorParameters = function () { return []; };
var UUID_VALIDATOR = {
    provide: __WEBPACK_IMPORTED_MODULE_1__angular_forms__["f" /* NG_VALIDATORS */],
    useExisting: Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["forwardRef"])(function () { return UUIDValidator; }),
    multi: true
};
var UUIDValidator = (function () {
    function UUIDValidator() {
    }
    /**
     * @return {?}
     */
    UUIDValidator.prototype.ngOnInit = function () {
        this.validator = uuid(this.uuid);
    };
    /**
     * @param {?} changes
     * @return {?}
     */
    UUIDValidator.prototype.ngOnChanges = function (changes) {
        for (var /** @type {?} */ key in changes) {
            if (key === 'uuid') {
                this.validator = uuid(changes[key].currentValue);
                if (this.onChange) {
                    this.onChange();
                }
            }
        }
    };
    /**
     * @param {?} c
     * @return {?}
     */
    UUIDValidator.prototype.validate = function (c) {
        return this.validator(c);
    };
    /**
     * @param {?} fn
     * @return {?}
     */
    UUIDValidator.prototype.registerOnValidatorChange = function (fn) {
        this.onChange = fn;
    };
    return UUIDValidator;
}());
UUIDValidator.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Directive"], args: [{
                selector: '[uuid][formControlName],[uuid][formControl],[uuid][ngModel]',
                providers: [UUID_VALIDATOR]
            },] },
];
/**
 * @nocollapse
 */
UUIDValidator.ctorParameters = function () { return []; };
UUIDValidator.propDecorators = {
    'uuid': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"] },],
};
var CustomValidators = {
    arrayLength: arrayLength,
    base64: base64,
    creditCard: creditCard,
    date: date,
    dateISO: dateISO,
    digits: digits,
    email: email,
    equal: equal,
    equalTo: equalTo,
    gt: gt,
    gte: gte,
    json: json,
    lt: lt,
    lte: lte,
    max: max,
    maxDate: maxDate,
    min: min,
    minDate: minDate,
    notEqual: notEqual,
    notEqualTo: notEqualTo,
    number: number,
    property: property,
    range: range,
    rangeLength: rangeLength,
    url: url,
    uuid: uuid
};
var CustomDirectives = [
    ArrayLengthValidator,
    Base64Validator,
    CreditCardValidator,
    DateValidator,
    DateISOValidator,
    DigitsValidator,
    EmailValidator,
    EqualValidator,
    EqualToValidator,
    GreaterThanValidator,
    GreaterThanEqualValidator,
    JSONValidator,
    LessThanValidator,
    LessThanEqualValidator,
    MaxValidator,
    MaxDateValidator,
    MinValidator,
    MinDateValidator,
    NotEqualValidator,
    NotEqualToValidator,
    NumberValidator,
    PropertyValidator,
    RangeValidator,
    RangeLengthValidator,
    UrlValidator,
    UUIDValidator
];
var CustomFormsModule = (function () {
    function CustomFormsModule() {
    }
    return CustomFormsModule;
}());
CustomFormsModule.decorators = [
    { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"], args: [{
                declarations: [CustomDirectives],
                exports: [CustomDirectives]
            },] },
];
/**
 * @nocollapse
 */
CustomFormsModule.ctorParameters = function () { return []; };
/**
 * Generated bundle index. Do not edit.
 */

//# sourceMappingURL=ng4-validators.es5.js.map


/***/ }),

/***/ "./src/app/services/user.datasource.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return UserDataSource; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_rxjs_BehaviorSubject__ = __webpack_require__("./node_modules/rxjs/_esm5/BehaviorSubject.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_rxjs_operators__ = __webpack_require__("./node_modules/rxjs/_esm5/operators.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_rxjs_observable_of__ = __webpack_require__("./node_modules/rxjs/_esm5/observable/of.js");



var UserDataSource = /** @class */ (function () {
    function UserDataSource(httpService) {
        this.httpService = httpService;
        this.userSubject = new __WEBPACK_IMPORTED_MODULE_0_rxjs_BehaviorSubject__["a" /* BehaviorSubject */]([]);
        this.loadingSubject = new __WEBPACK_IMPORTED_MODULE_0_rxjs_BehaviorSubject__["a" /* BehaviorSubject */](false);
        this.loading$ = this.loadingSubject.asObservable();
    }
    UserDataSource.prototype.loadUser = function (pageIndex) {
        var _this = this;
        this.loadingSubject.next(true);
        this.httpService.findUser('get/user', pageIndex).pipe(Object(__WEBPACK_IMPORTED_MODULE_1_rxjs_operators__["catchError"])(function () { return Object(__WEBPACK_IMPORTED_MODULE_2_rxjs_observable_of__["a" /* of */])([]); }), Object(__WEBPACK_IMPORTED_MODULE_1_rxjs_operators__["finalize"])(function () { return _this.loadingSubject.next(false); }))
            .subscribe(function (users) { return _this.userSubject.next(users); });
    };
    UserDataSource.prototype.connect = function (collectionViewer) {
        return this.userSubject.asObservable();
    };
    UserDataSource.prototype.disconnect = function (collectionViewer) {
        this.userSubject.complete();
        this.loadingSubject.complete();
    };
    return UserDataSource;
}());



/***/ }),

/***/ "./src/app/users/add/add.component.css":
/***/ (function(module, exports) {

module.exports = ".form-full-width {\r\n    width: 100%;\r\n}\r\n\r\nmat-icon {\r\n    cursor: pointer;\r\n}"

/***/ }),

/***/ "./src/app/users/add/add.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"main-content\">\r\n    <div class=\"container-fluid\">\r\n        <div class=\"row\">\r\n            <div class=\"col-md-offset-3 col-md-6\">\r\n                <div class=\"card\">\r\n                    <form [formGroup]=\"userForm\" novalidate (ngSubmit)=\"onSubmit()\" #f=\"ngForm\">\r\n                        <div class=\"card-header card-header-icon\" data-background-color=\"rose\">\r\n                            <i class=\"material-icons\">mail_outline</i>\r\n                        </div>\r\n                        <div class=\"card-content\">\r\n                            <h4 class=\"card-title\">Forma za registraciju korisnika</h4>\r\n\r\n                            <mat-form-field class=\"form-full-width\">\r\n                                <mat-label>Ime korisnika</mat-label>\r\n                                <input type=\"text\" matInput placeholder=\"Ime\" formControlName=\"name\">\r\n                                <mat-error>\r\n                                    <span *ngIf=\"userForm.controls.name.hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                </mat-error>\r\n                            </mat-form-field>\r\n\r\n\r\n                            <mat-form-field class=\"form-full-width\">\r\n                                <mat-label>Email</mat-label>\r\n                                <input type=\"email\" matInput placeholder=\"primer@gmail.rs\" formControlName=\"email\">\r\n                                <mat-error>\r\n                                    <span *ngIf=\"userForm.controls.email.hasError('required') && userForm.controls.email.touched\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                    <span *ngIf=\"userForm.controls.email.hasError('pattern')\">Uneta email adresa nije ispravna <strong>molimo proverite format</strong></span>\r\n                                    <span *ngIf=\"userForm.controls.email.invalid  && userForm.controls.email.touched\"><strong>{{errorEmail}}</strong></span>\r\n                                </mat-error>\r\n                            </mat-form-field>\r\n\r\n\r\n                            <mat-form-field class=\"form-full-width\">\r\n                                <mat-label>Lozinka</mat-label>\r\n                                <input [type]=\"hide ? 'password' : 'text'\" matInput placeholder=\"lozinka\" formControlName=\"password\">\r\n                                <mat-icon matSuffix (click)=\"hide = !hide\">{{ hide ? 'visibility_off' : 'visibility'}}</mat-icon>\r\n                                <mat-error>\r\n                                    <span *ngIf=\"userForm.controls.password.hasError('required') && userForm.controls.password.touched\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                    <span *ngIf=\"userForm.controls.password.invalid\"><strong>{{errorPasswordLength}}</strong></span>\r\n                                </mat-error>\r\n                            </mat-form-field>\r\n\r\n                            <mat-form-field class=\"form-full-width\">\r\n                                <mat-label>Potvrdite lozinku</mat-label>\r\n                                <input type=\"password\" matInput placeholder=\"potvrdite lozinku\" formControlName=\"confirmPassword\">\r\n                                <mat-error>\r\n                                    <span *ngIf=\"userForm.controls.confirmPassword.hasError('required') && userForm.controls.confirmPassword.touched\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                    <span *ngIf=\"userForm.controls.confirmPassword.hasError('equalTo')\">Lozinke se ne <strong>poklapaju</strong></span>\r\n                                </mat-error>\r\n                            </mat-form-field>\r\n                            <div class=\"category form-category\">\r\n                                <ul>\r\n                                    <li>Lozinka mora biti duza od 8 karaktera!</li>\r\n                                </ul>\r\n                            </div>\r\n                            <div class=\"form-footer text-right\">\r\n                                <div class=\"form-group \">\r\n                                    <button type=\"submit\" class=\"btn btn-rose btn-fill btn-wd\" [disabled]=\"!userForm.valid\">Registruj!</button>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </form>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>"

/***/ }),

/***/ "./src/app/users/add/add.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AddComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__services_http_service__ = __webpack_require__("./src/app/services/http.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__notifications_notifications_service__ = __webpack_require__("./src/app/notifications/notifications.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_ng4_validators__ = __webpack_require__("./node_modules/ng4-validators/ng4-validators.es5.js");
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
        this.hide = true;
        this.errorMessage = false;
        this.emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    }
    AddComponent.prototype.ngOnInit = function () {
        var password = new __WEBPACK_IMPORTED_MODULE_1__angular_forms__["c" /* FormControl */]('', __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required);
        var confirmPassword = new __WEBPACK_IMPORTED_MODULE_1__angular_forms__["c" /* FormControl */]('', [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required, __WEBPACK_IMPORTED_MODULE_4_ng4_validators__["b" /* CustomValidators */].equalTo(password)]);
        // init userForm
        this.userForm = this.fb.group({
            name: ['', __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            email: ['', [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].pattern(this.emailPattern), __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].email]],
            password: password,
            confirmPassword: confirmPassword
        });
    };
    AddComponent.prototype.resetForm = function () {
        this.myNgForm.resetForm();
    };
    AddComponent.prototype.onSubmit = function () {
        var _this = this;
        var fd = new FormData();
        var formInput = this.userForm.value;
        delete formInput.confirmPassword;
        fd.append("json", JSON.stringify(formInput));
        this.http.postFormData('create/user', fd).subscribe(function (httpResponse) {
            if (httpResponse.status === 201) {
                _this.alert.showNotification('Uspesno ste dodali novog korisnika', 'success', '');
                // this.userForm.reset();
                _this.resetForm();
                // this.userForm.markAsPristine();
                // this.userForm.markAsUntouched();
                // this.userForm.updateValueAndValidity();
            }
        }, function (error) {
            if (error.status == 422) {
                if (error.json().password != null) {
                    // set password as invalid and trigger error
                    _this.userForm.controls.password.setErrors({ 'incorrect': true });
                    _this.errorPasswordLength = error.json().password[0];
                }
                else {
                    _this.errorPasswordLength = '';
                }
                if (error.json().email != null) {
                    // set password as invalid and trigger error
                    _this.userForm.controls.email.setErrors({ 'incorrect': true });
                    _this.errorEmail = error.json().email[0];
                }
                else {
                    _this.errorEmail = '';
                }
                if (_this.errorPasswordLength != '') {
                    _this.alert.showNotification('Greska uneta sifra treba da bude duza od 8 karatera', 'danger', 'notifications');
                }
                if (_this.errorEmail != '') {
                    _this.alert.showNotification('email adresa ' + _this.userForm.controls.email.value + ' vec postoji molimo izaberite drugu', 'info', 'notifications');
                }
            }
        });
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])('f'),
        __metadata("design:type", Object)
    ], AddComponent.prototype, "myNgForm", void 0);
    AddComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'app-add',
            template: __webpack_require__("./src/app/users/add/add.component.html"),
            styles: [__webpack_require__("./src/app/users/add/add.component.css")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["b" /* FormBuilder */],
            __WEBPACK_IMPORTED_MODULE_2__services_http_service__["a" /* HttpService */],
            __WEBPACK_IMPORTED_MODULE_3__notifications_notifications_service__["a" /* NotificationsService */]])
    ], AddComponent);
    return AddComponent;
}());



/***/ }),

/***/ "./src/app/users/edit/edit.component.css":
/***/ (function(module, exports) {

module.exports = ".form-full-width {\r\n    width: 100%;\r\n}\r\n\r\nmat-icon {\r\n    cursor: pointer;\r\n}"

/***/ }),

/***/ "./src/app/users/edit/edit.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"main-content\">\r\n    <div class=\"container-fluid\">\r\n        <div class=\"row\">\r\n            <div class=\"col-md-8 col-lg-8\">\r\n                <div class=\"card\">\r\n                    <form [formGroup]=\"userForm\" novalidate (ngSubmit)=\"onSubmit()\">\r\n                        <div class=\"card-header card-header-icon\" data-background-color=\"rose\">\r\n                            <i class=\"material-icons\">create</i>\r\n                        </div>\r\n                        <div class=\"card-content\">\r\n                            <h4 class=\"card-title\">Forma za uredjivanje podataka o korisniku</h4>\r\n\r\n                            <mat-form-field class=\"form-full-width\">\r\n                                <mat-label>Ime korisnika</mat-label>\r\n                                <input type=\"text\" matInput placeholder=\"Ime\" formControlName=\"name\">\r\n                                <mat-error>\r\n                                    <span *ngIf=\"userForm.controls.name.hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                </mat-error>\r\n                            </mat-form-field>\r\n\r\n                            <mat-form-field class=\"form-full-width\">\r\n                                <mat-label>Email</mat-label>\r\n                                <input type=\"email\" matInput placeholder=\"primer@gmail.rs\" formControlName=\"email\">\r\n                                <mat-error>\r\n                                    <span *ngIf=\"userForm.controls.email.hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                    <span *ngIf=\"userForm.controls.email.hasError('pattern')\">Uneta email adresa nije ispravna<strong>molimo proverite format</strong></span>\r\n                                </mat-error>\r\n                            </mat-form-field>\r\n\r\n                            <mat-form-field class=\"form-full-width\">\r\n                                <mat-label>Stara lozinka</mat-label>\r\n                                <input [type]=\"hide2 ? 'password':'text'\" matInput placeholder=\"stara lozinka\" formControlName=\"old_password\">\r\n                                <mat-icon matSuffix (click)=\"hide2 = !hide2\">{{ hide2 ? 'visibility_off' : 'visibility'}}</mat-icon>\r\n                                <mat-error>\r\n                                    <span *ngIf=\"userForm.controls.old_password.hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                    <span *ngIf=\"userForm.controls.password.invalid\"><strong>{{errorOldPassword}}</strong></span>\r\n                                </mat-error>\r\n                            </mat-form-field>\r\n\r\n                            <mat-form-field class=\"form-full-width\">\r\n                                <mat-label>Nova lozinka</mat-label>\r\n                                <input [type]=\"hide ? 'password':'text'\" matInput placeholder=\"unesite novu lozinku\" formControlName=\"password\">\r\n                                <mat-icon matSuffix (click)=\"hide = !hide\">{{ hide ? 'visibility_off' : 'visibility'}}</mat-icon>\r\n                                <mat-error>\r\n                                    <span *ngIf=\"userForm.controls.password.hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                    <span *ngIf=\"userForm.controls.password.invalid\"><strong>{{errorPasswordLength}}</strong></span>\r\n                                </mat-error>\r\n                            </mat-form-field>\r\n\r\n                            <mat-form-field class=\"form-full-width\">\r\n                                <mat-label>Potvrdi novu lozinku</mat-label>\r\n                                <input type=\"password\" matInput placeholder=\"potvdite novu lozinku\" formControlName=\"confirmPassword\">\r\n                                <mat-error>\r\n                                    <span *ngIf=\"userForm.controls.confirmPassword.hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                    <span *ngIf=\"userForm.controls.confirmPassword.hasError('equalTo')\">Lozinke se ne <strong>poklapaju</strong></span>\r\n                                </mat-error>\r\n                            </mat-form-field>\r\n\r\n                            <div class=\"category form-category\">\r\n                                <ul>\r\n                                    <li>Lozinka mora biti duza od 8 karaktera!</li>\r\n                                </ul>\r\n                            </div>\r\n                            <div class=\"form-footer text-right\">\r\n                                <div class=\"form-group\">\r\n\r\n                                    <button type=\"submit\" class=\"btn btn-rose btn-fill btn-wd\" [disabled]=\"!userForm.valid\">Sačuvaj</button>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </form>\r\n                    <!-- end content-->\r\n                </div>\r\n                <!--  end card  -->\r\n            </div>\r\n            <!-- end col-md-12 -->\r\n\r\n            <div class=\"col-md-4 col-lg-3\">\r\n                <div class=\"card card-pricing card-raised\">\r\n                    <div class=\"content\">\r\n                        <h6 class=\"category\">User profil</h6>\r\n                        <div class=\"icon icon-rose\">\r\n                            <i class=\"material-icons\">supervisor_account</i>\r\n                        </div>\r\n                        <h3 class=\"card-title\">{{userForm.controls.name.value}}</h3>\r\n                        <div class=\"row\">\r\n                            <div class=\"form-group\">\r\n                                <p class=\"form-control-static\">{{userForm.controls.email.value}}</p>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n\r\n\r\n        <!-- end row -->\r\n    </div>\r\n    <div class=\"row\">\r\n        <div class=\"col-md-3 col-lg-6\">\r\n\r\n        </div>\r\n    </div>\r\n</div>"

/***/ }),

/***/ "./src/app/users/edit/edit.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return EditComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__services_http_service__ = __webpack_require__("./src/app/services/http.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__notifications_notifications_service__ = __webpack_require__("./src/app/notifications/notifications.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_ng4_validators__ = __webpack_require__("./node_modules/ng4-validators/ng4-validators.es5.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};






var EditComponent = /** @class */ (function () {
    function EditComponent(fb, http, alert, route) {
        this.fb = fb;
        this.http = http;
        this.alert = alert;
        this.route = route;
        this.hide = true;
        this.hide2 = true;
        this.errorOldPassword = '';
        this.errorPasswordLength = '';
        this.errorEmail = '';
        this.emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    }
    EditComponent.prototype.ngOnInit = function () {
        var _this = this;
        // get url params for user ID
        this.subscriptionParams = this.route.params.subscribe(function (params) { return (_this.id = params.id); });
        var password = new __WEBPACK_IMPORTED_MODULE_3__angular_forms__["c" /* FormControl */](''); //  creating new controler for password input field for matching passwords 
        var confirmPassword = new __WEBPACK_IMPORTED_MODULE_3__angular_forms__["c" /* FormControl */]('', __WEBPACK_IMPORTED_MODULE_5_ng4_validators__["b" /* CustomValidators */].equalTo(password)); // creating new controler for confirmPass.
        // init FromGroup  userForm
        this.userForm = this.fb.group({
            name: ['', __WEBPACK_IMPORTED_MODULE_3__angular_forms__["l" /* Validators */].required],
            email: ['', [__WEBPACK_IMPORTED_MODULE_3__angular_forms__["l" /* Validators */].required, __WEBPACK_IMPORTED_MODULE_3__angular_forms__["l" /* Validators */].pattern(this.emailPattern)]],
            old_password: [''],
            password: password,
            confirmPassword: confirmPassword
        });
        this.loadingData(); // calling func for loading data in form
    };
    // init for loading and fills fields with values from server
    EditComponent.prototype.loadingData = function () {
        var _this = this;
        this.http.get('patch/initialize/user/' + this.id, 1).subscribe(function (httpResponse) {
            if (httpResponse.status === 200) {
                var serverData = httpResponse.json();
                _this.userForm.controls.name.setValue(serverData.name);
                _this.userForm.controls.email.setValue(serverData.email);
                _this.currentEmail = serverData.email;
            }
        });
    };
    // destroying all subscripions
    EditComponent.prototype.ngOnDestroy = function () {
        this.subscriptionParams.unsubscribe();
    };
    EditComponent.prototype.onSubmit = function () {
        var _this = this;
        var fd = new FormData(); // init new FormData 
        var formInput = this.userForm.value;
        delete formInput.confirmPassword; // deleting FormControl 
        // checking for password if input is empty dont sent password
        if (formInput.old_password == "") {
            delete formInput.old_password;
            delete formInput.password;
        }
        if (this.currentEmail === formInput.email) {
            delete formInput.email;
        }
        // append values from input fields to FormData
        fd.append('json', JSON.stringify(formInput));
        // patching values from edit form
        this.http.postFormData('patch/user/' + this.id, fd).subscribe(function (httpResponse) {
            if (httpResponse.status === 204) {
                // handling success response
                _this.alert.showNotification('uspesno ste izmenili podatke', 'success', 'notifications');
            }
            else {
                _this.alert.showNotification('Desila se greska sa serverom', 'danger', 'notifications');
            }
        }, function (error) {
            if (error.status === 422) {
                _this.errorMessage = true;
                // handling common error for wrong inputs
                if (error.json().password != null) {
                    // set password as invalid and trigger error
                    _this.userForm.controls.password.setErrors({ 'incorrect': true });
                    _this.errorPasswordLength = error.json().password[0];
                }
                else {
                    _this.errorPasswordLength = '';
                }
                if (error.json().old_password != null) {
                    // set password as invalid and trigger error
                    _this.userForm.controls.old_password.setErrors({ 'incorrect': true });
                    _this.errorOldPassword = error.json().old_password[0];
                }
                else {
                    _this.errorOldPassword = '';
                }
                if (error.json().email != null) {
                    if (_this.currentEmail != _this.userForm.controls.email.value) {
                        // set password as invalid and trigger error
                        _this.userForm.controls.email.setErrors({ 'incorrect': true });
                        _this.errorEmail = error.json().email[0];
                        console.log('uspesno', _this.currentEmail);
                    }
                    else {
                        _this.userForm.controls.email.setErrors({ 'incorrrect': false });
                    }
                }
                else {
                    _this.errorEmail = '';
                }
                if (_this.errorPasswordLength != '') {
                    _this.alert.showNotification('Greska uneta sifra treba da bude duza od 8 karatera', 'danger', 'notifications');
                }
                if (_this.errorOldPassword != '') {
                    _this.alert.showNotification('Greska pogresno uneta sifra', 'danger', 'notifications');
                }
                if (_this.errorEmail != '') {
                    _this.alert.showNotification('email adresa ' + _this.userForm.controls.email.value + ' vec postoji molimo izaberite drugu', 'info', 'notifications');
                }
            }
        });
    };
    EditComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'app-edit',
            template: __webpack_require__("./src/app/users/edit/edit.component.html"),
            styles: [__webpack_require__("./src/app/users/edit/edit.component.css")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_3__angular_forms__["b" /* FormBuilder */],
            __WEBPACK_IMPORTED_MODULE_1__services_http_service__["a" /* HttpService */],
            __WEBPACK_IMPORTED_MODULE_2__notifications_notifications_service__["a" /* NotificationsService */],
            __WEBPACK_IMPORTED_MODULE_4__angular_router__["a" /* ActivatedRoute */]])
    ], EditComponent);
    return EditComponent;
}());



/***/ }),

/***/ "./src/app/users/users.component.css":
/***/ (function(module, exports) {

module.exports = ".loading_spinner {\r\n    position: absolute;\r\n    margin-left: 50%;\r\n    margin-top: 70px;\r\n}"

/***/ }),

/***/ "./src/app/users/users.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"main-content\">\r\n    <div class=\"container-fluid\">\r\n        <div class=\"row\">\r\n            <div class=\"col-md-12\">\r\n                <div class=\"col-md-1 col-md-offset-11\">\r\n                    <button (click)=\"OnAddUser()\" mat-raised-button class=\"btn btn-rose btn-lg\">DODAJ</button>\r\n                </div>\r\n                <div class=\"card\">\r\n                    <div class=\"card-header card-header-icon\" data-background-color=\"darkred\">\r\n                        <i class=\"material-icons\">assignment</i>\r\n                    </div>\r\n                    <div class=\"card-content\">\r\n                        <h4 class=\"card-title\">Korisnici</h4>\r\n                        <div class=\"toolbar\">\r\n                            <!--        Here you can write extra buttons/actions for the toolbar              -->\r\n                        </div>\r\n                        <div class=\"material-datatables table-responsive\">\r\n                            <div class=\"loading_spinner\" *ngIf=\"dataSource.loading$ | async\">\r\n\r\n                                <mat-spinner [diameter]=\"40\"></mat-spinner>\r\n\r\n                            </div>\r\n                            <mat-table class=\"winery-table mat-elevation-z8\" [dataSource]=\"dataSource\" matSort matSortDisableClear>\r\n\r\n                                <ng-container matColumnDef=\"id\">\r\n\r\n                                    <mat-header-cell *matHeaderCellDef>ID</mat-header-cell>\r\n\r\n                                    <mat-cell *matCellDef=\"let element\">{{element.id}}</mat-cell>\r\n\r\n                                </ng-container>\r\n\r\n                                <ng-container matColumnDef=\"name\">\r\n\r\n                                    <mat-header-cell *matHeaderCellDef>Ime</mat-header-cell>\r\n\r\n                                    <mat-cell class=\"description-cell\" *matCellDef=\"let element\">{{element.name}}</mat-cell>\r\n\r\n                                </ng-container>\r\n                                <ng-container matColumnDef=\"actions\">\r\n\r\n                                    <mat-header-cell *matHeaderCellDef>Akcije</mat-header-cell>\r\n\r\n                                    <mat-cell class=\"actions-cell\" *matCellDef=\"let element\">\r\n                                        <button (click)=\"OnEditUser(element.id)\" type=\"button\" rel=\"tooltip\" class=\"btn btn-just-icon btn-success rounded\"><i class=\"material-icons\">edit</i></button>\r\n                                        <button (click)=\"OnDeleteUser(element.id, element.name)\" type=\"button\" rel=\"tooltip\" class=\"btn btn-just-icon btn-danger rounded\"><i class=\"material-icons\">close</i></button>\r\n                                    </mat-cell>\r\n\r\n                                </ng-container>\r\n\r\n                                <mat-header-row *matHeaderRowDef=\"displayedColumns\"></mat-header-row>\r\n\r\n                                <mat-row *matRowDef=\"let row; columns: displayedColumns\"></mat-row>\r\n\r\n                            </mat-table>\r\n\r\n                            <mat-paginator [length]=\"total\" [pageSize]=\"pageSize\"></mat-paginator>\r\n                        </div>\r\n                    </div>\r\n                    <!-- end content-->\r\n                </div>\r\n                <!--  end card  -->\r\n            </div>\r\n            <!-- end col-md-12 -->\r\n        </div>\r\n        <!-- end row -->\r\n    </div>\r\n</div>"

/***/ }),

/***/ "./src/app/users/users.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return UsersComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_material__ = __webpack_require__("./node_modules/@angular/material/esm5/material.es5.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_rxjs_operators__ = __webpack_require__("./node_modules/rxjs/_esm5/operators.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__services_user_datasource__ = __webpack_require__("./src/app/services/user.datasource.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__services_http_service__ = __webpack_require__("./src/app/services/http.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__notifications_notifications_service__ = __webpack_require__("./src/app/notifications/notifications.service.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};







var UsersComponent = /** @class */ (function () {
    function UsersComponent(router, http, alert) {
        this.router = router;
        this.http = http;
        this.alert = alert;
        this.displayedColumns = ["id", "name", "actions"];
    }
    UsersComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.dataSource = new __WEBPACK_IMPORTED_MODULE_4__services_user_datasource__["a" /* UserDataSource */](this.http);
        this.dataSource.loadUser(1);
        this.http.get('get/user', 1).subscribe(function (httpResponse) {
            if (httpResponse.status === 200) {
                _this.total = httpResponse.json().total;
                _this.pageSize = httpResponse.json().per_page;
            }
        }, function (error) {
            _this.alert.showNotification('Greska na serveru, molimo pokusajte kasnije!', 'danger', '');
        });
    };
    UsersComponent.prototype.ngAfterViewInit = function () {
        var _this = this;
        this.paginator.page.pipe(Object(__WEBPACK_IMPORTED_MODULE_3_rxjs_operators__["tap"])(function () { return _this.loadUserPage(); })).subscribe();
    };
    UsersComponent.prototype.loadUserPage = function () {
        this.dataSource.loadUser(this.paginator.pageIndex + 1);
        console.log("loadUserPage triggered!: ", this.paginator.pageIndex);
    };
    UsersComponent.prototype.OnEditUser = function (id) {
        this.router.navigate(["users/edit/", id]);
    };
    UsersComponent.prototype.OnAddUser = function () {
        this.router.navigate(["users/add"]);
    };
    UsersComponent.prototype.OnDeleteUser = function (id, name) {
        var _this = this;
        swal({
            title: "Da li ste sigurni da \u017Eelite da obri\u0161ete korisnika " + name + " ?",
            text: "Podatke nije moguće povratiti nakon brisanja!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-success",
            cancelButtonClass: "btn btn-danger",
            confirmButtonText: "Yes, delete it!",
            buttonsStyling: false
        }).then(function () {
            _this.http.delete("delete/user/" + id).subscribe(function (httpResponse) {
                if (httpResponse.status === 204) {
                    swal({
                        title: "Obrisano!",
                        text: "Korisnik " + name + " je uspesno obrisan!.",
                        type: "success",
                        confirmButtonClass: "btn btn-success",
                        buttonsStyling: false
                    });
                    _this.http.get("get/user", 1).subscribe(function (data) {
                        _this.paginator.length = data.json().total;
                    });
                    _this.dataSource = new __WEBPACK_IMPORTED_MODULE_4__services_user_datasource__["a" /* UserDataSource */](_this.http);
                    _this.dataSource.loadUser(_this.paginator.pageIndex);
                }
                (function (error) {
                    _this.alert.showNotification("Greska korisnik" + name + "nije obrisan!", "danger", "error");
                });
            });
        });
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])(__WEBPACK_IMPORTED_MODULE_2__angular_material__["s" /* MatPaginator */]),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_2__angular_material__["s" /* MatPaginator */])
    ], UsersComponent.prototype, "paginator", void 0);
    UsersComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: "app-users",
            template: __webpack_require__("./src/app/users/users.component.html"),
            styles: [__webpack_require__("./src/app/users/users.component.css")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__angular_router__["b" /* Router */],
            __WEBPACK_IMPORTED_MODULE_5__services_http_service__["a" /* HttpService */],
            __WEBPACK_IMPORTED_MODULE_6__notifications_notifications_service__["a" /* NotificationsService */]])
    ], UsersComponent);
    return UsersComponent;
}());



/***/ }),

/***/ "./src/app/users/users.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "UsersModule", function() { return UsersModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_common__ = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__users_routing__ = __webpack_require__("./src/app/users/users.routing.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__users_component__ = __webpack_require__("./src/app/users/users.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__edit_edit_component__ = __webpack_require__("./src/app/users/edit/edit.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__add_add_component__ = __webpack_require__("./src/app/users/add/add.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__angular_material__ = __webpack_require__("./node_modules/@angular/material/esm5/material.es5.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9_ng4_validators__ = __webpack_require__("./node_modules/ng4-validators/ng4-validators.es5.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};










var UsersModule = /** @class */ (function () {
    function UsersModule() {
    }
    UsersModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [
                __WEBPACK_IMPORTED_MODULE_2__angular_common__["b" /* CommonModule */],
                __WEBPACK_IMPORTED_MODULE_1__angular_router__["c" /* RouterModule */].forChild(__WEBPACK_IMPORTED_MODULE_4__users_routing__["a" /* UsersTable */]),
                __WEBPACK_IMPORTED_MODULE_3__angular_forms__["e" /* FormsModule */],
                __WEBPACK_IMPORTED_MODULE_3__angular_forms__["k" /* ReactiveFormsModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["h" /* MatDatepickerModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["r" /* MatNativeDateModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["l" /* MatFormFieldModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["o" /* MatInputModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["y" /* MatSelectModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["F" /* MatTableModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["D" /* MatSortModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["t" /* MatPaginatorModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["v" /* MatProgressSpinnerModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["n" /* MatIconModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["I" /* MatTooltipModule */],
                __WEBPACK_IMPORTED_MODULE_9_ng4_validators__["a" /* CustomFormsModule */]
            ],
            declarations: [
                __WEBPACK_IMPORTED_MODULE_5__users_component__["a" /* UsersComponent */],
                __WEBPACK_IMPORTED_MODULE_6__edit_edit_component__["a" /* EditComponent */],
                __WEBPACK_IMPORTED_MODULE_7__add_add_component__["a" /* AddComponent */]
            ], exports: [
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["h" /* MatDatepickerModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["r" /* MatNativeDateModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["l" /* MatFormFieldModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["o" /* MatInputModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["y" /* MatSelectModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["F" /* MatTableModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["D" /* MatSortModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["t" /* MatPaginatorModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["n" /* MatIconModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["I" /* MatTooltipModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["v" /* MatProgressSpinnerModule */]
            ]
        })
    ], UsersModule);
    return UsersModule;
}());



/***/ }),

/***/ "./src/app/users/users.routing.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return UsersTable; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__users_component__ = __webpack_require__("./src/app/users/users.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__edit_edit_component__ = __webpack_require__("./src/app/users/edit/edit.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__add_add_component__ = __webpack_require__("./src/app/users/add/add.component.ts");



var UsersTable = [
    {
        path: '',
        children: [{
                path: '',
                component: __WEBPACK_IMPORTED_MODULE_0__users_component__["a" /* UsersComponent */]
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
//# sourceMappingURL=users.module.chunk.js.map