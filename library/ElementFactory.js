//--------------------------------------------------------------------------
// Static Class - add or remove element from DOM
//--------------------------------------------------------------------------
/**
*  ...
*
*  @version    1.0
*  @copyright  Copyright (c) 2017.
*  @license    Creative Commons (BY-NC-SA)
*  @since      Feb 13, 2017
*  @author     Michaela Olausson <michaelaolausson@gmail.com>
*/
function ElementFactory () {
    this.create = function ( type, obj ) { // type of element + array of attributes and values.
        var obj = obj;
        var type = type;
        var element = document.createElement(type);
        for ( key in obj ) {
            element[key] = obj[key];
            console.log( key + " = " + obj[key] );
        }
       return element;
    },
    this.createText = function () {

    }, 
    this.remove = function () {

    }
}