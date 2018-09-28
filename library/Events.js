//------------------------------------------------------------------
// Events Static Class
// Crossbrowser polyfill
//
// Methods originally by Rune Körnefors 
// OOP-config by Michaela Olausson
//------------------------------------------------------------------
var Events = {
	addListener: function(obj, type, fn) {
		if (obj.addEventListener) obj.addEventListener(type,fn,false);
		else obj.attachEvent("on"+type,fn);
	}, 

	removeListener: function(obj, type, fn) {
		if (obj.removeEventListener) obj.removeEventListener(type,fn,false);
		else obj.detachEvent("on"+type,fn);
	} 
};
