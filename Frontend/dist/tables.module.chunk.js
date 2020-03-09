webpackJsonp(["tables.module"],{

/***/ "./src/app/tables/datatable.net/datatable.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"main-content\">\r\n    <div class=\"container-fluid\">\r\n        <div class=\"row\">\r\n            <div class=\"col-md-12\">\r\n                <div class=\"card\">\r\n                    <div class=\"card-header card-header-icon\" data-background-color=\"purple\">\r\n                        <i class=\"material-icons\">assignment</i>\r\n                    </div>\r\n                    <div class=\"card-content\">\r\n                        <h4 class=\"card-title\">DataTables.net</h4>\r\n                        <div class=\"toolbar\">\r\n                            <!--        Here you can write extra buttons/actions for the toolbar              -->\r\n                        </div>\r\n                        <div class=\"material-datatables table-responsive\">\r\n                            <table id=\"datatables\" class=\"table table-striped table-no-bordered table-hover\" cellspacing=\"0\" width=\"100%\" style=\"width:100%\">\r\n                                <thead>\r\n                                    <tr>\r\n                                      <th>{{ dataTable.headerRow[0] }}</th>\r\n                                      <th>{{ dataTable.headerRow[1] }}</th>\r\n                                      <th>{{ dataTable.headerRow[2] }}</th>\r\n                                      <th>{{ dataTable.headerRow[3] }}</th>\r\n                                      <th>{{ dataTable.headerRow[4] }}</th>\r\n                                      <th class=\"disabled-sorting text-right\">{{ dataTable.headerRow[5] }}</th>\r\n                                    </tr>\r\n                                </thead>\r\n                                <tfoot>\r\n                                    <tr>\r\n                                      <th>{{ dataTable.footerRow[0] }}</th>\r\n                                      <th>{{ dataTable.footerRow[1] }}</th>\r\n                                      <th>{{ dataTable.footerRow[2] }}</th>\r\n                                      <th>{{ dataTable.footerRow[3] }}</th>\r\n                                      <th>{{ dataTable.footerRow[4] }}</th>\r\n                                      <th class=\"text-right\">{{ dataTable.footerRow[5] }}</th>\r\n                                    </tr>\r\n                                </tfoot>\r\n                                <tbody>\r\n                                    <tr *ngFor=\"let row of dataTable.dataRows\">\r\n                                        <td>{{row[0]}}</td>\r\n                                        <td>{{row[1]}}</td>\r\n                                        <td>{{row[2]}}</td>\r\n                                        <td>{{row[3]}}</td>\r\n                                        <td>{{row[4]}}</td>\r\n                                        <td class=\"text-right\">\r\n                                            <a href=\"#/tables/datatables.net\" class=\"btn btn-simple btn-info btn-icon like\"><i class=\"material-icons\">favorite</i></a>\r\n                                            <a href=\"#/tables/datatables.net\" class=\"btn btn-simple btn-warning btn-icon edit\"><i class=\"material-icons\">dvr</i></a>\r\n                                            <a href=\"#/tables/datatables.net\" class=\"btn btn-simple btn-danger btn-icon remove\"><i class=\"material-icons\">close</i></a>\r\n                                        </td>\r\n                                    </tr>\r\n                                </tbody>\r\n                            </table>\r\n                        </div>\r\n                    </div>\r\n                    <!-- end content-->\r\n                </div>\r\n                <!--  end card  -->\r\n            </div>\r\n            <!-- end col-md-12 -->\r\n        </div>\r\n        <!-- end row -->\r\n    </div>\r\n</div>\r\n"

/***/ }),

/***/ "./src/app/tables/datatable.net/datatable.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return DataTableComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};

var DataTableComponent = /** @class */ (function () {
    function DataTableComponent() {
    }
    DataTableComponent.prototype.ngOnInit = function () {
        this.dataTable = {
            headerRow: ['Name', 'Position', 'Office', 'Age', 'Date', 'Actions'],
            footerRow: ['Name', 'Position', 'Office', 'Age', 'Start Date', 'Actions'],
            dataRows: [
                ['Airi Satou', 'Andrew Mike', 'Develop', '2013', '99,225', ''],
                ['Angelica Ramos', 'John Doe', 'Design', '2012', '89,241', 'btn-round'],
                ['Ashton Cox', 'Alex Mike', 'Design', '2010', '92,144', 'btn-simple'],
                ['Bradley Greer', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Brenden Wagner', 'Paul Dickens', 'Communication', '2015', '69,201', ''],
                ['Brielle Williamson', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Caesar Vance', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Cedric Kelly', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Charde Marshall', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Colleen Hurst', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Dai Rios', 'Andrew Mike', 'Develop', '2013', '99,225', ''],
                ['Doris Wilder', 'John Doe', 'Design', '2012', '89,241', 'btn-round'],
                ['Fiona Green', 'Alex Mike', 'Design', '2010', '92,144', 'btn-simple'],
                ['Garrett Winters', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Gavin Cortez', 'Paul Dickens', 'Communication', '2015', '69,201', ''],
                ['Gavin Joyce', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Gloria Little', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Haley Kennedy', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Herrod Chandler', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Hope Fuentes', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Howard Hatfield', 'Andrew Mike', 'Develop', '2013', '99,225', ''],
                ['Jena Gaines', 'John Doe', 'Design', '2012', '89,241', 'btn-round'],
                ['Jenette Caldwell', 'Alex Mike', 'Design', '2010', '92,144', 'btn-simple'],
                ['Jennifer Chang', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Martena Mccray', 'Paul Dickens', 'Communication', '2015', '69,201', ''],
                ['Michael Silva', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Michelle House', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Paul Byrd', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Prescott Bartlett', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Quinn Flynn', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Rhona Davidson', 'Andrew Mike', 'Develop', '2013', '99,225', ''],
                ['Shou Itou', 'John Doe', 'Design', '2012', '89,241', 'btn-round'],
                ['Sonya Frost', 'Alex Mike', 'Design', '2010', '92,144', 'btn-simple'],
                ['Suki Burks', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Tatyana Fitzpatrick', 'Paul Dickens', 'Communication', '2015', '69,201', ''],
                ['Tiger Nixon', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Timothy Mooney', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Unity Butler', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Vivian Harrell', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['Yuri Berry', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round']
            ]
        };
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });
        var table = $('#datatables').DataTable();
        // Edit record
        table.on('click', '.edit', function () {
            var $tr = $(this).closest('tr');
            var data = table.row($tr).data();
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });
        // Delete a record
        table.on('click', '.remove', function (e) {
            var $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
        });
        //Like record
        table.on('click', '.like', function () {
            alert('You clicked on Like button');
        });
        //  Activate the tooltips
        $('[rel="tooltip"]').tooltip();
    };
    DataTableComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            moduleId: module.i,
            selector: 'data-table-cmp',
            template: __webpack_require__("./src/app/tables/datatable.net/datatable.component.html")
        })
    ], DataTableComponent);
    return DataTableComponent;
}());



/***/ }),

/***/ "./src/app/tables/extendedtable/extendedtable.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"main-content\">\r\n    <div class=\"container-fluid\">\r\n        <div class=\"row\">\r\n            <div class=\"col-md-12\">\r\n                <div class=\"card\">\r\n                    <div class=\"card-header card-header-icon\" data-background-color=\"rose\">\r\n                        <i class=\"material-icons\">assignment</i>\r\n                    </div>\r\n                    <div class=\"card-content\">\r\n                        <h4 class=\"card-title\">Simple Table</h4>\r\n                        <div class=\"table-responsive\">\r\n                            <table class=\"table\">\r\n                                    <thead>\r\n                                        <tr>\r\n                                          <th class=\"text-center\">{{ tableData1.headerRow[0] }}</th>\r\n                                          <th>{{ tableData1.headerRow[1] }}</th>\r\n                                          <th>{{ tableData1.headerRow[2] }}</th>\r\n                                          <th>{{ tableData1.headerRow[3] }}</th>\r\n                                          <th class=\"text-right\">{{ tableData1.headerRow[4] }}</th>\r\n                                          <th class=\"text-right\">{{ tableData1.headerRow[5] }}</th>\r\n                                        </tr>\r\n                                    </thead>\r\n                                  <tbody>\r\n                                      <tr *ngFor=\"let row of tableData1.dataRows\">\r\n                                          <td class=\"text-center\">{{row[0]}}</td>\r\n                                          <td>{{row[1]}}</td>\r\n                                          <td>{{row[2]}}</td>\r\n                                          <td>{{row[3]}}</td>\r\n                                          <td class=\"text-right\">&euro; {{row[4]}}</td>\r\n                                          <td class=\"td-actions text-right\">\r\n                                              <button type=\"button\" rel=\"tooltip\" class=\"btn btn-info {{row[5]}}\">\r\n                                                  <i class=\"material-icons\">person</i>\r\n                                              </button>\r\n                                              <button type=\"button\" rel=\"tooltip\" class=\"btn btn-success {{row[5]}}\">\r\n                                                  <i class=\"material-icons\">edit</i>\r\n                                              </button>\r\n                                              <button type=\"button\" rel=\"tooltip\" class=\"btn btn-danger {{row[5]}}\">\r\n                                                  <i class=\"material-icons\">close</i>\r\n                                              </button>\r\n                                          </td>\r\n                                      </tr>\r\n                                  </tbody>\r\n                            </table>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <div class=\"col-md-12\">\r\n                <div class=\"card\">\r\n                    <div class=\"card-header card-header-icon\" data-background-color=\"rose\">\r\n                        <i class=\"material-icons\">assignment</i>\r\n                    </div>\r\n                    <div class=\"card-content\">\r\n                        <h4 class=\"card-title\">Striped Table</h4>\r\n                        <div class=\"table-responsive\">\r\n                            <table class=\"table table-striped\">\r\n                                    <thead>\r\n                                        <tr>\r\n                                          <th class=\"text-center\">{{ tableData2.headerRow[0] }}</th>\r\n                                          <th>{{ tableData2.headerRow[1] }}</th>\r\n                                          <th>{{ tableData2.headerRow[2] }}</th>\r\n                                          <th>{{ tableData2.headerRow[3] }}</th>\r\n                                          <th>{{ tableData2.headerRow[4] }}</th>\r\n                                          <th class=\"text-right\">{{ tableData2.headerRow[5] }}</th>\r\n                                          <th class=\"text-right\">{{ tableData2.headerRow[6] }}</th>\r\n                                        </tr>\r\n                                    </thead>\r\n                                  <tbody>\r\n                                      <tr *ngFor=\"let row of tableData2.dataRows\">\r\n                                          <td class=\"text-center\">{{row.id}}</td>\r\n                                          <td>\r\n                                              <div [ngSwitch]=\"row.ischecked\">\r\n                                                  <div *ngSwitchCase=\"true\">\r\n                                                      <div class=\"checkbox\">\r\n                                                          <label>\r\n                                                              <input type=\"checkbox\" name=\"optionsCheckboxes\" checked>\r\n                                                          </label>\r\n                                                      </div>\r\n                                                  </div>\r\n                                                  <div *ngSwitchDefault>\r\n                                                      <div class=\"checkbox\">\r\n                                                          <label>\r\n                                                              <input type=\"checkbox\" name=\"optionsCheckboxes\">\r\n                                                          </label>\r\n                                                      </div>\r\n                                                  </div>\r\n\r\n                                              </div>\r\n                                          </td>\r\n                                          <td>{{row.product_name}}</td>\r\n                                          <td>{{row.type}}</td>\r\n                                          <td>{{row.quantity}}</td>\r\n                                          <td class=\"text-right\">{{ row.price | currency:'EUR':true:'1.2-2'}}</td>\r\n                                          <td class=\"text-right\">\r\n                                              &euro; {{row.amount}}\r\n                                          </td>\r\n                                      </tr>\r\n                                      <tr>\r\n                                          <td colspan=\"5\"></td>\r\n                                          <td class=\"td-total\">\r\n                                              Total\r\n                                          </td>\r\n                                          <td class=\"td-price\">\r\n                                              <small>&euro;</small>12,999\r\n                                          </td>\r\n                                      </tr>\r\n                                  </tbody>\r\n                            </table>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <div class=\"col-md-12\">\r\n                <div class=\"card\">\r\n                    <div class=\"card-header card-header-icon\" data-background-color=\"rose\">\r\n                        <i class=\"material-icons\">assignment</i>\r\n                    </div>\r\n                    <div class=\"card-content\">\r\n                        <h4 class=\"card-title\">Shopping Cart Table</h4>\r\n                        <div class=\"table-responsive\">\r\n                            <table class=\"table table-shopping\">\r\n                                    <thead>\r\n                                        <tr>\r\n                                          <th class=\"text-center\">{{ tableData3.headerRow[0] }}</th>\r\n                                          <th>{{ tableData3.headerRow[1] }}</th>\r\n                                          <th class=\"th-description\">{{ tableData3.headerRow[2] }}</th>\r\n                                          <th class=\"th-description\">{{ tableData3.headerRow[3] }}</th>\r\n                                          <th class=\"text-right\">{{ tableData3.headerRow[4] }}</th>\r\n                                          <th class=\"text-right\">{{ tableData3.headerRow[5] }}</th>\r\n                                          <th class=\"text-right\">{{ tableData3.headerRow[6] }}</th>\r\n                                          <th></th>\r\n                                        </tr>\r\n                                    </thead>\r\n                                  <tbody>\r\n                                      <tr *ngFor=\"let row of tableData3.dataRows\">\r\n                                          <td>\r\n                                              <div class=\"img-container\">\r\n                                                  <img src=\"../../assets/img/{{row[0]}}.jpg\" alt=\"...\">\r\n                                              </div>\r\n                                          </td>\r\n                                          <td class=\"td-name\">\r\n                                              <a href=\"{{row[1]}}\">{{row[2]}}</a>\r\n                                              <br />\r\n                                              <small>{{row[3]}}</small>\r\n                                          </td>\r\n                                          <td>{{row[4]}}</td>\r\n                                          <td>\r\n                                              {{row[5]}}\r\n                                          </td>\r\n                                          <td class=\"td-number text-right\"><small>&euro;</small> {{row[6]}}</td>\r\n                                          <td class=\"td-number\">\r\n                                              {{row[7]}}\r\n                                              <div class=\"btn-group\">\r\n                                                  <button class=\"btn btn-round btn-info btn-xs\"> <i class=\"material-icons\">remove</i> </button>\r\n                                                  <button class=\"btn btn-round btn-info btn-xs\"> <i class=\"material-icons\">add</i> </button>\r\n                                              </div>\r\n                                          </td>\r\n                                          <td class=\"td-number\">\r\n                                              <small>&euro;</small>{{row[8]}}\r\n                                          </td>\r\n                                          <td class=\"td-actions\">\r\n                                              <button type=\"button\" rel=\"tooltip\" data-placement=\"left\" title=\"Remove item\" class=\"btn btn-simple\">\r\n                                                  <i class=\"material-icons\">close</i>\r\n                                              </button>\r\n                                          </td>\r\n                                      </tr>\r\n                                      <tr>\r\n                                          <td colspan=\"5\"></td>\r\n                                          <td class=\"td-total\">\r\n                                              Total\r\n                                          </td>\r\n                                          <td colspan=\"1\" class=\"td-price\">\r\n                                              {{getTotal()| currency:'EUR':true:'1.2-2'}}\r\n                                          </td>\r\n                                          <td></td>\r\n                                      </tr>\r\n                                      <tr>\r\n                                          <td colspan=\"6\"></td>\r\n                                          <td colspan=\"2\" class=\"text-right\">\r\n                                              <button type=\"button\" class=\"btn btn-info btn-round\">Complete Purchase <i class=\"material-icons\">keyboard_arrow_right</i></button>\r\n                                          </td>\r\n                                      </tr>\r\n                                  </tbody>\r\n                            </table>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>\r\n"

/***/ }),

/***/ "./src/app/tables/extendedtable/extendedtable.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ExtendedTableComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};

var ExtendedTableComponent = /** @class */ (function () {
    function ExtendedTableComponent() {
    }
    ExtendedTableComponent.prototype.ngOnInit = function () {
        // Init Tooltips
        // $('[rel="tooltip"]').tooltip();
        this.tableData1 = {
            headerRow: ['#', 'Name', 'Job Position', 'Since', 'Salary', 'Actions'],
            dataRows: [
                ['1', 'Andrew Mike', 'Develop', '2013', '99,225', ''],
                ['2', 'John Doe', 'Design', '2012', '89,241', 'btn-round'],
                ['3', 'Alex Mike', 'Design', '2010', '92,144', 'btn-simple'],
                ['4', 'Mike Monday', 'Marketing', '2013', '49,990', 'btn-round'],
                ['5', 'Paul Dickens', 'Communication', '2015', '69,201', '']
            ]
        };
        this.tableData2 = {
            headerRow: ['#', '', 'Product Name', 'Type', 'Qty', 'Price', 'Amount'],
            dataRows: [
                { id: 1, ischecked: true, product_name: 'Moleskine Agenda', type: 'Office', quantity: 25, price: 49, amount: '1,225' },
                { id: 2, ischecked: true, product_name: 'Stabilo Pen', type: 'Office', quantity: 30, price: 10.99, amount: '109' },
                { id: 3, ischecked: true, product_name: 'A4 Paper Pack', type: 'Office', quantity: 50, price: 49, amount: '1,225' },
                { id: 4, ischecked: false, product_name: 'Apple iPad', type: 'Meeting', quantity: 10, price: 499.00, amount: '4,990' },
                { id: 5, ischecked: false, product_name: 'Apple iPhone', type: 'Communication', quantity: 10, price: 599.00, amount: '5,999' }
            ]
        };
        this.tableData3 = {
            headerRow: ['', 'PRODUCT', 'COLOR', 'SIZE', 'PRICE', 'QTY', 'AMOUNT'],
            dataRows: [
                ['product1', '#jacket', 'Spring Jacket', 'by Dolce&Gabbana', 'Red', 'M', '549', '1', '549'],
                ['product2', '#pants', 'Short Pants', 'by Pucci', 'Purple', 'M', '499', '2', '998'],
                ['product3', '#nothing', 'Pencil Skirt', 'by Valentino', 'White', 'XL', '799', '1', '799']
            ]
        };
    };
    ExtendedTableComponent.prototype.getTotal = function () {
        var total = 0;
        for (var i = 0; i < this.tableData3.dataRows.length; i++) {
            var integer = parseInt(this.tableData3.dataRows[i][8]);
            total += integer;
        }
        return total;
    };
    ;
    ExtendedTableComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            moduleId: module.i,
            selector: 'extended-table-cmp',
            template: __webpack_require__("./src/app/tables/extendedtable/extendedtable.component.html")
        })
    ], ExtendedTableComponent);
    return ExtendedTableComponent;
}());



/***/ }),

/***/ "./src/app/tables/regulartable/regulartable.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"main-content\">\r\n    <div class=\"container-fluid\">\r\n        <div class=\"row\">\r\n            <div class=\"col-md-12\">\r\n                <div class=\"card\">\r\n                    <div class=\"card-header card-header-icon\" data-background-color=\"rose\">\r\n                        <i class=\"material-icons\">assignment</i>\r\n                    </div>\r\n                    <div class=\"card-content\">\r\n                        <h4 class=\"card-title\">Simple Table</h4>\r\n                        <div class=\"content table-responsive\">\r\n                          <table class=\"table\">\r\n                                  <thead class=\"text-primary\">\r\n                                      <tr>\r\n                                        <th *ngFor=\"let cell of tableData1.headerRow\">{{ cell }}</th>\r\n                                      </tr>\r\n                                  </thead>\r\n                                <tbody>\r\n                                    <tr *ngFor=\"let row of tableData1.dataRows\">\r\n                                        <td>{{row[0]}}</td>\r\n                                        <td>{{row[1]}}</td>\r\n                                        <td>{{row[2]}}</td>\r\n                                        <td class=\"text-primary\">{{row[3]}}</td>\r\n\r\n                                    </tr>\r\n                                </tbody>\r\n                          </table>\r\n\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"col-md-12\">\r\n                    <div class=\"card card-plain\">\r\n                        <div class=\"card-header card-header-icon\" data-background-color=\"rose\">\r\n                            <i class=\"material-icons\">assignment</i>\r\n                        </div>\r\n                        <h4 class=\"card-title\">Table on Plain Background</h4>\r\n                        <p class=\"category\">Here is a subtitle for this table</p>\r\n                        <div class=\"card-content table-responsive\">\r\n                          <table class=\"table table-hover\">\r\n                              <thead>\r\n                                  <tr>\r\n                                    <th *ngFor=\"let cell of tableData2.headerRow\">{{ cell }}</th>\r\n                                  </tr>\r\n                              </thead>\r\n                            <tbody>\r\n                                    <tr *ngFor=\"let row of tableData2.dataRows\">\r\n                                        <td *ngFor=\"let cell of row\">{{cell}}</td>\r\n                                    </tr>\r\n                            </tbody>\r\n                          </table>\r\n\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"col-md-12\">\r\n                    <div class=\"card\">\r\n                        <div class=\"card-header card-header-icon\" data-background-color=\"rose\">\r\n                            <i class=\"material-icons\">assignment</i>\r\n                        </div>\r\n                        <h4 class=\"card-title\">Regular Table with Colors</h4>\r\n                        <div class=\"card-content table-responsive table-full-width\">\r\n                            <table class=\"table table-hover\">\r\n                                <thead>\r\n                                    <tr>\r\n                                      <th *ngFor=\"let cell of tableData3.headerRow\">{{ cell }}</th>\r\n                                    </tr>\r\n                                </thead>\r\n                              <tbody>\r\n                                      <tr class=\"success\">\r\n                                          <td *ngFor=\"let cell of tableData3.dataRows[0]\">{{cell}}</td>\r\n                                      </tr>\r\n                                      <tr>\r\n                                          <td *ngFor=\"let cell of tableData3.dataRows[1]\">{{cell}}</td>\r\n                                      </tr>\r\n                                      <tr class=\"info\">\r\n                                          <td *ngFor=\"let cell of tableData3.dataRows[2]\">{{cell}}</td>\r\n                                      </tr>\r\n                                      <tr>\r\n                                          <td *ngFor=\"let cell of tableData3.dataRows[3]\">{{cell}}</td>\r\n                                      </tr>\r\n                                      <tr class=\"danger\">\r\n                                          <td *ngFor=\"let cell of tableData3.dataRows[4]\">{{cell}}</td>\r\n                                      </tr>\r\n                                      <tr>\r\n                                          <td *ngFor=\"let cell of tableData3.dataRows[5]\">{{cell}}</td>\r\n                                      </tr>\r\n                                      <tr class=\"warning\">\r\n                                          <td *ngFor=\"let cell of tableData3.dataRows[6]\">{{cell}}</td>\r\n                                      </tr>\r\n                              </tbody>\r\n                            </table>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>\r\n"

/***/ }),

/***/ "./src/app/tables/regulartable/regulartable.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return RegularTableComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};

var RegularTableComponent = /** @class */ (function () {
    function RegularTableComponent() {
    }
    RegularTableComponent.prototype.ngOnInit = function () {
        this.tableData1 = {
            headerRow: ['Name', 'Country', 'City', 'Salary'],
            dataRows: [
                ['Dakota Rice', 'Niger', 'Oud-Turnhout', '$36,738'],
                ['Minerva Hooper', 'Curaçao', 'Sinaai-Waas', '$23,789'],
                ['Sage Rodriguez', 'Netherlands', 'Baileux', '$56,142'],
                ['Philip Chaney', 'Korea, South', 'Overland Park', '$38,735'],
                ['Doris Greene', 'Malawi', 'Feldkirchen in Kärnten', '$63,542'],
                ['Mason Porter', 'Chile', 'Gloucester', '$78,615']
            ]
        };
        this.tableData2 = {
            headerRow: ['ID', 'Name', 'Salary', 'Country', 'City'],
            dataRows: [
                ['1', 'Dakota Rice', '$36,738', 'Niger', 'Oud-Turnhout'],
                ['2', 'Minerva Hooper', '$23,789', 'Curaçao', 'Sinaai-Waas'],
                ['3', 'Sage Rodriguez', '$56,142', 'Netherlands', 'Baileux'],
                ['4', 'Philip Chaney', '$38,735', 'Korea, South', 'Overland Park'],
                ['5', 'Doris Greene', '$63,542', 'Malawi', 'Feldkirchen in Kärnten',],
                ['6', 'Mason Porter', '$78,615', 'Chile', 'Gloucester']
            ]
        };
        this.tableData3 = {
            headerRow: ['ID', 'Name', 'Salary', 'Country', 'City'],
            dataRows: [
                ['1', 'Dakota Rice (Success)', '$36,738', 'Niger', 'Oud-Turnhout'],
                ['2', 'Minerva Hooper', '$23,789', 'Curaçao', 'Sinaai-Waas'],
                ['3', 'Sage Rodriguez (Info)', '$56,142', 'Netherlands', 'Baileux'],
                ['4', 'Philip Chaney', '$38,735', 'Korea, South', 'Overland Park'],
                ['5', 'Doris Greene (Danger)', '$63,542', 'Malawi', 'Feldkirchen in Kärnten',],
                ['6', 'Mason Porter', '$78,615', 'Chile', 'Gloucester'],
                ['7', 'Mike Chaney (Warning)', '$38,735', 'Romania', 'Bucharest']
            ]
        };
    };
    RegularTableComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            moduleId: module.i,
            selector: 'regular-table-cmp',
            template: __webpack_require__("./src/app/tables/regulartable/regulartable.component.html")
        })
    ], RegularTableComponent);
    return RegularTableComponent;
}());



/***/ }),

/***/ "./src/app/tables/tables.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TablesModule", function() { return TablesModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_common__ = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__tables_routing__ = __webpack_require__("./src/app/tables/tables.routing.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__extendedtable_extendedtable_component__ = __webpack_require__("./src/app/tables/extendedtable/extendedtable.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__regulartable_regulartable_component__ = __webpack_require__("./src/app/tables/regulartable/regulartable.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__datatable_net_datatable_component__ = __webpack_require__("./src/app/tables/datatable.net/datatable.component.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};








var TablesModule = /** @class */ (function () {
    function TablesModule() {
    }
    TablesModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [
                __WEBPACK_IMPORTED_MODULE_2__angular_common__["b" /* CommonModule */],
                __WEBPACK_IMPORTED_MODULE_1__angular_router__["c" /* RouterModule */].forChild(__WEBPACK_IMPORTED_MODULE_4__tables_routing__["a" /* TablesRoutes */]),
                __WEBPACK_IMPORTED_MODULE_3__angular_forms__["e" /* FormsModule */]
            ],
            declarations: [
                __WEBPACK_IMPORTED_MODULE_5__extendedtable_extendedtable_component__["a" /* ExtendedTableComponent */],
                __WEBPACK_IMPORTED_MODULE_7__datatable_net_datatable_component__["a" /* DataTableComponent */],
                __WEBPACK_IMPORTED_MODULE_6__regulartable_regulartable_component__["a" /* RegularTableComponent */],
            ]
        })
    ], TablesModule);
    return TablesModule;
}());



/***/ }),

/***/ "./src/app/tables/tables.routing.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return TablesRoutes; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__extendedtable_extendedtable_component__ = __webpack_require__("./src/app/tables/extendedtable/extendedtable.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__regulartable_regulartable_component__ = __webpack_require__("./src/app/tables/regulartable/regulartable.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__datatable_net_datatable_component__ = __webpack_require__("./src/app/tables/datatable.net/datatable.component.ts");



var TablesRoutes = [
    {
        path: '',
        children: [{
                path: 'regular',
                component: __WEBPACK_IMPORTED_MODULE_1__regulartable_regulartable_component__["a" /* RegularTableComponent */]
            }]
    }, {
        path: '',
        children: [{
                path: 'extended',
                component: __WEBPACK_IMPORTED_MODULE_0__extendedtable_extendedtable_component__["a" /* ExtendedTableComponent */]
            }]
    }, {
        path: '',
        children: [{
                path: 'datatables.net',
                component: __WEBPACK_IMPORTED_MODULE_2__datatable_net_datatable_component__["a" /* DataTableComponent */]
            }]
    }
];


/***/ })

});
//# sourceMappingURL=tables.module.chunk.js.map