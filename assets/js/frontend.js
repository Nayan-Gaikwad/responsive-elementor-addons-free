/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 116);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
var global = module.exports = typeof window != 'undefined' && window.Math == Math
  ? window : typeof self != 'undefined' && self.Math == Math ? self
  // eslint-disable-next-line no-new-func
  : Function('return this')();
if (typeof __g == 'number') __g = global; // eslint-disable-line no-undef


/***/ }),
/* 1 */
/***/ (function(module, exports) {

module.exports = function (it) {
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};


/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

var store = __webpack_require__(22)('wks');
var uid = __webpack_require__(21);
var Symbol = __webpack_require__(0).Symbol;
var USE_SYMBOL = typeof Symbol == 'function';

var $exports = module.exports = function (name) {
  return store[name] || (store[name] =
    USE_SYMBOL && Symbol[name] || (USE_SYMBOL ? Symbol : uid)('Symbol.' + name));
};

$exports.store = store;


/***/ }),
/* 3 */,
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(1);
module.exports = function (it) {
  if (!isObject(it)) throw TypeError(it + ' is not an object!');
  return it;
};


/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

// Thank's IE8 for his funny defineProperty
module.exports = !__webpack_require__(6)(function () {
  return Object.defineProperty({}, 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),
/* 6 */
/***/ (function(module, exports) {

module.exports = function (exec) {
  try {
    return !!exec();
  } catch (e) {
    return true;
  }
};


/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

var dP = __webpack_require__(30);
var createDesc = __webpack_require__(43);
module.exports = __webpack_require__(5) ? function (object, key, value) {
  return dP.f(object, key, createDesc(1, value));
} : function (object, key, value) {
  object[key] = value;
  return object;
};


/***/ }),
/* 8 */,
/* 9 */,
/* 10 */
/***/ (function(module, exports) {

var toString = {}.toString;

module.exports = function (it) {
  return toString.call(it).slice(8, -1);
};


/***/ }),
/* 11 */
/***/ (function(module, exports) {

var core = module.exports = { version: '2.6.11' };
if (typeof __e == 'number') __e = core; // eslint-disable-line no-undef


/***/ }),
/* 12 */,
/* 13 */,
/* 14 */,
/* 15 */
/***/ (function(module, exports) {

// 7.2.1 RequireObjectCoercible(argument)
module.exports = function (it) {
  if (it == undefined) throw TypeError("Can't call method on  " + it);
  return it;
};


/***/ }),
/* 16 */,
/* 17 */,
/* 18 */,
/* 19 */,
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

// 7.1.15 ToLength
var toInteger = __webpack_require__(24);
var min = Math.min;
module.exports = function (it) {
  return it > 0 ? min(toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
};


/***/ }),
/* 21 */
/***/ (function(module, exports) {

var id = 0;
var px = Math.random();
module.exports = function (key) {
  return 'Symbol('.concat(key === undefined ? '' : key, ')_', (++id + px).toString(36));
};


/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

var core = __webpack_require__(11);
var global = __webpack_require__(0);
var SHARED = '__core-js_shared__';
var store = global[SHARED] || (global[SHARED] = {});

(module.exports = function (key, value) {
  return store[key] || (store[key] = value !== undefined ? value : {});
})('versions', []).push({
  version: core.version,
  mode: __webpack_require__(46) ? 'pure' : 'global',
  copyright: '© 2019 Denis Pushkarev (zloirock.ru)'
});


/***/ }),
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

// optional / simple context binding
var aFunction = __webpack_require__(34);
module.exports = function (fn, that, length) {
  aFunction(fn);
  if (that === undefined) return fn;
  switch (length) {
    case 1: return function (a) {
      return fn.call(that, a);
    };
    case 2: return function (a, b) {
      return fn.call(that, a, b);
    };
    case 3: return function (a, b, c) {
      return fn.call(that, a, b, c);
    };
  }
  return function (/* ...args */) {
    return fn.apply(that, arguments);
  };
};


/***/ }),
/* 24 */
/***/ (function(module, exports) {

// 7.1.4 ToInteger
var ceil = Math.ceil;
var floor = Math.floor;
module.exports = function (it) {
  return isNaN(it = +it) ? 0 : (it > 0 ? floor : ceil)(it);
};


/***/ }),
/* 25 */,
/* 26 */,
/* 27 */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(0);
var core = __webpack_require__(11);
var hide = __webpack_require__(7);
var redefine = __webpack_require__(28);
var ctx = __webpack_require__(23);
var PROTOTYPE = 'prototype';

var $export = function (type, name, source) {
  var IS_FORCED = type & $export.F;
  var IS_GLOBAL = type & $export.G;
  var IS_STATIC = type & $export.S;
  var IS_PROTO = type & $export.P;
  var IS_BIND = type & $export.B;
  var target = IS_GLOBAL ? global : IS_STATIC ? global[name] || (global[name] = {}) : (global[name] || {})[PROTOTYPE];
  var exports = IS_GLOBAL ? core : core[name] || (core[name] = {});
  var expProto = exports[PROTOTYPE] || (exports[PROTOTYPE] = {});
  var key, own, out, exp;
  if (IS_GLOBAL) source = name;
  for (key in source) {
    // contains in native
    own = !IS_FORCED && target && target[key] !== undefined;
    // export native or passed
    out = (own ? target : source)[key];
    // bind timers to global for call from export context
    exp = IS_BIND && own ? ctx(out, global) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
    // extend global
    if (target) redefine(target, key, out, type & $export.U);
    // export
    if (exports[key] != out) hide(exports, key, exp);
    if (IS_PROTO && expProto[key] != out) expProto[key] = out;
  }
};
global.core = core;
// type bitmap
$export.F = 1;   // forced
$export.G = 2;   // global
$export.S = 4;   // static
$export.P = 8;   // proto
$export.B = 16;  // bind
$export.W = 32;  // wrap
$export.U = 64;  // safe
$export.R = 128; // real proto method for `library`
module.exports = $export;


/***/ }),
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(0);
var hide = __webpack_require__(7);
var has = __webpack_require__(44);
var SRC = __webpack_require__(21)('src');
var $toString = __webpack_require__(45);
var TO_STRING = 'toString';
var TPL = ('' + $toString).split(TO_STRING);

__webpack_require__(11).inspectSource = function (it) {
  return $toString.call(it);
};

(module.exports = function (O, key, val, safe) {
  var isFunction = typeof val == 'function';
  if (isFunction) has(val, 'name') || hide(val, 'name', key);
  if (O[key] === val) return;
  if (isFunction) has(val, SRC) || hide(val, SRC, O[key] ? '' + O[key] : TPL.join(String(key)));
  if (O === global) {
    O[key] = val;
  } else if (!safe) {
    delete O[key];
    hide(O, key, val);
  } else if (O[key]) {
    O[key] = val;
  } else {
    hide(O, key, val);
  }
// add fake Function#toString for correct work wrapped methods / constructors with methods like LoDash isNative
})(Function.prototype, TO_STRING, function toString() {
  return typeof this == 'function' && this[SRC] || $toString.call(this);
});


/***/ }),
/* 29 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var regexpFlags = __webpack_require__(72);

var nativeExec = RegExp.prototype.exec;
// This always refers to the native implementation, because the
// String#replace polyfill uses ./fix-regexp-well-known-symbol-logic.js,
// which loads this file before patching the method.
var nativeReplace = String.prototype.replace;

var patchedExec = nativeExec;

var LAST_INDEX = 'lastIndex';

var UPDATES_LAST_INDEX_WRONG = (function () {
  var re1 = /a/,
      re2 = /b*/g;
  nativeExec.call(re1, 'a');
  nativeExec.call(re2, 'a');
  return re1[LAST_INDEX] !== 0 || re2[LAST_INDEX] !== 0;
})();

// nonparticipating capturing group, copied from es5-shim's String#split patch.
var NPCG_INCLUDED = /()??/.exec('')[1] !== undefined;

var PATCH = UPDATES_LAST_INDEX_WRONG || NPCG_INCLUDED;

if (PATCH) {
  patchedExec = function exec(str) {
    var re = this;
    var lastIndex, reCopy, match, i;

    if (NPCG_INCLUDED) {
      reCopy = new RegExp('^' + re.source + '$(?!\\s)', regexpFlags.call(re));
    }
    if (UPDATES_LAST_INDEX_WRONG) lastIndex = re[LAST_INDEX];

    match = nativeExec.call(re, str);

    if (UPDATES_LAST_INDEX_WRONG && match) {
      re[LAST_INDEX] = re.global ? match.index + match[0].length : lastIndex;
    }
    if (NPCG_INCLUDED && match && match.length > 1) {
      // Fix browsers whose `exec` methods don't consistently return `undefined`
      // for NPCG, like IE8. NOTE: This doesn' work for /(.?)?/
      // eslint-disable-next-line no-loop-func
      nativeReplace.call(match[0], reCopy, function () {
        for (i = 1; i < arguments.length - 2; i++) {
          if (arguments[i] === undefined) match[i] = undefined;
        }
      });
    }

    return match;
  };
}

module.exports = patchedExec;


/***/ }),
/* 30 */
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__(4);
var IE8_DOM_DEFINE = __webpack_require__(31);
var toPrimitive = __webpack_require__(33);
var dP = Object.defineProperty;

exports.f = __webpack_require__(5) ? Object.defineProperty : function defineProperty(O, P, Attributes) {
  anObject(O);
  P = toPrimitive(P, true);
  anObject(Attributes);
  if (IE8_DOM_DEFINE) try {
    return dP(O, P, Attributes);
  } catch (e) { /* empty */ }
  if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported!');
  if ('value' in Attributes) O[P] = Attributes.value;
  return O;
};


/***/ }),
/* 31 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = !__webpack_require__(5) && !__webpack_require__(6)(function () {
  return Object.defineProperty(__webpack_require__(32)('div'), 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),
/* 32 */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(1);
var document = __webpack_require__(0).document;
// typeof document.createElement is 'object' in old IE
var is = isObject(document) && isObject(document.createElement);
module.exports = function (it) {
  return is ? document.createElement(it) : {};
};


/***/ }),
/* 33 */
/***/ (function(module, exports, __webpack_require__) {

// 7.1.1 ToPrimitive(input [, PreferredType])
var isObject = __webpack_require__(1);
// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
module.exports = function (it, S) {
  if (!isObject(it)) return it;
  var fn, val;
  if (S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  if (typeof (fn = it.valueOf) == 'function' && !isObject(val = fn.call(it))) return val;
  if (!S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  throw TypeError("Can't convert object to primitive value");
};


/***/ }),
/* 34 */
/***/ (function(module, exports) {

module.exports = function (it) {
  if (typeof it != 'function') throw TypeError(it + ' is not a function!');
  return it;
};


/***/ }),
/* 35 */,
/* 36 */,
/* 37 */,
/* 38 */,
/* 39 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// 22.1.3.8 Array.prototype.find(predicate, thisArg = undefined)
var $export = __webpack_require__(27);
var $find = __webpack_require__(47)(5);
var KEY = 'find';
var forced = true;
// Shouldn't skip holes
if (KEY in []) Array(1)[KEY](function () { forced = false; });
$export($export.P + $export.F * forced, 'Array', {
  find: function find(callbackfn /* , that = undefined */) {
    return $find(this, callbackfn, arguments.length > 1 ? arguments[1] : undefined);
  }
});
__webpack_require__(52)(KEY);


/***/ }),
/* 40 */
/***/ (function(module, exports, __webpack_require__) {

// 7.1.13 ToObject(argument)
var defined = __webpack_require__(15);
module.exports = function (it) {
  return Object(defined(it));
};


/***/ }),
/* 41 */,
/* 42 */
/***/ (function(module, exports) {

function _interopRequireDefault(obj) {
  return obj && obj.__esModule ? obj : {
    "default": obj
  };
}

module.exports = _interopRequireDefault;

/***/ }),
/* 43 */
/***/ (function(module, exports) {

module.exports = function (bitmap, value) {
  return {
    enumerable: !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable: !(bitmap & 4),
    value: value
  };
};


/***/ }),
/* 44 */
/***/ (function(module, exports) {

var hasOwnProperty = {}.hasOwnProperty;
module.exports = function (it, key) {
  return hasOwnProperty.call(it, key);
};


/***/ }),
/* 45 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(22)('native-function-to-string', Function.toString);


/***/ }),
/* 46 */
/***/ (function(module, exports) {

module.exports = false;


/***/ }),
/* 47 */
/***/ (function(module, exports, __webpack_require__) {

// 0 -> Array#forEach
// 1 -> Array#map
// 2 -> Array#filter
// 3 -> Array#some
// 4 -> Array#every
// 5 -> Array#find
// 6 -> Array#findIndex
var ctx = __webpack_require__(23);
var IObject = __webpack_require__(48);
var toObject = __webpack_require__(40);
var toLength = __webpack_require__(20);
var asc = __webpack_require__(49);
module.exports = function (TYPE, $create) {
  var IS_MAP = TYPE == 1;
  var IS_FILTER = TYPE == 2;
  var IS_SOME = TYPE == 3;
  var IS_EVERY = TYPE == 4;
  var IS_FIND_INDEX = TYPE == 6;
  var NO_HOLES = TYPE == 5 || IS_FIND_INDEX;
  var create = $create || asc;
  return function ($this, callbackfn, that) {
    var O = toObject($this);
    var self = IObject(O);
    var f = ctx(callbackfn, that, 3);
    var length = toLength(self.length);
    var index = 0;
    var result = IS_MAP ? create($this, length) : IS_FILTER ? create($this, 0) : undefined;
    var val, res;
    for (;length > index; index++) if (NO_HOLES || index in self) {
      val = self[index];
      res = f(val, index, O);
      if (TYPE) {
        if (IS_MAP) result[index] = res;   // map
        else if (res) switch (TYPE) {
          case 3: return true;             // some
          case 5: return val;              // find
          case 6: return index;            // findIndex
          case 2: result.push(val);        // filter
        } else if (IS_EVERY) return false; // every
      }
    }
    return IS_FIND_INDEX ? -1 : IS_SOME || IS_EVERY ? IS_EVERY : result;
  };
};


/***/ }),
/* 48 */
/***/ (function(module, exports, __webpack_require__) {

// fallback for non-array-like ES3 and non-enumerable old V8 strings
var cof = __webpack_require__(10);
// eslint-disable-next-line no-prototype-builtins
module.exports = Object('z').propertyIsEnumerable(0) ? Object : function (it) {
  return cof(it) == 'String' ? it.split('') : Object(it);
};


/***/ }),
/* 49 */
/***/ (function(module, exports, __webpack_require__) {

// 9.4.2.3 ArraySpeciesCreate(originalArray, length)
var speciesConstructor = __webpack_require__(50);

module.exports = function (original, length) {
  return new (speciesConstructor(original))(length);
};


/***/ }),
/* 50 */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(1);
var isArray = __webpack_require__(51);
var SPECIES = __webpack_require__(2)('species');

module.exports = function (original) {
  var C;
  if (isArray(original)) {
    C = original.constructor;
    // cross-realm fallback
    if (typeof C == 'function' && (C === Array || isArray(C.prototype))) C = undefined;
    if (isObject(C)) {
      C = C[SPECIES];
      if (C === null) C = undefined;
    }
  } return C === undefined ? Array : C;
};


/***/ }),
/* 51 */
/***/ (function(module, exports, __webpack_require__) {

// 7.2.2 IsArray(argument)
var cof = __webpack_require__(10);
module.exports = Array.isArray || function isArray(arg) {
  return cof(arg) == 'Array';
};


/***/ }),
/* 52 */
/***/ (function(module, exports, __webpack_require__) {

// 22.1.3.31 Array.prototype[@@unscopables]
var UNSCOPABLES = __webpack_require__(2)('unscopables');
var ArrayProto = Array.prototype;
if (ArrayProto[UNSCOPABLES] == undefined) __webpack_require__(7)(ArrayProto, UNSCOPABLES, {});
module.exports = function (key) {
  ArrayProto[UNSCOPABLES][key] = true;
};


/***/ }),
/* 53 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var at = __webpack_require__(69)(true);

 // `AdvanceStringIndex` abstract operation
// https://tc39.github.io/ecma262/#sec-advancestringindex
module.exports = function (S, index, unicode) {
  return index + (unicode ? at(S, index).length : 1);
};


/***/ }),
/* 54 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var classof = __webpack_require__(70);
var builtinExec = RegExp.prototype.exec;

 // `RegExpExec` abstract operation
// https://tc39.github.io/ecma262/#sec-regexpexec
module.exports = function (R, S) {
  var exec = R.exec;
  if (typeof exec === 'function') {
    var result = exec.call(R, S);
    if (typeof result !== 'object') {
      throw new TypeError('RegExp exec method returned something other than an Object or null');
    }
    return result;
  }
  if (classof(R) !== 'RegExp') {
    throw new TypeError('RegExp#exec called on incompatible receiver');
  }
  return builtinExec.call(R, S);
};


/***/ }),
/* 55 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

__webpack_require__(71);
var redefine = __webpack_require__(28);
var hide = __webpack_require__(7);
var fails = __webpack_require__(6);
var defined = __webpack_require__(15);
var wks = __webpack_require__(2);
var regexpExec = __webpack_require__(29);

var SPECIES = wks('species');

var REPLACE_SUPPORTS_NAMED_GROUPS = !fails(function () {
  // #replace needs built-in support for named groups.
  // #match works fine because it just return the exec results, even if it has
  // a "grops" property.
  var re = /./;
  re.exec = function () {
    var result = [];
    result.groups = { a: '7' };
    return result;
  };
  return ''.replace(re, '$<a>') !== '7';
});

var SPLIT_WORKS_WITH_OVERWRITTEN_EXEC = (function () {
  // Chrome 51 has a buggy "split" implementation when RegExp#exec !== nativeExec
  var re = /(?:)/;
  var originalExec = re.exec;
  re.exec = function () { return originalExec.apply(this, arguments); };
  var result = 'ab'.split(re);
  return result.length === 2 && result[0] === 'a' && result[1] === 'b';
})();

module.exports = function (KEY, length, exec) {
  var SYMBOL = wks(KEY);

  var DELEGATES_TO_SYMBOL = !fails(function () {
    // String methods call symbol-named RegEp methods
    var O = {};
    O[SYMBOL] = function () { return 7; };
    return ''[KEY](O) != 7;
  });

  var DELEGATES_TO_EXEC = DELEGATES_TO_SYMBOL ? !fails(function () {
    // Symbol-named RegExp methods call .exec
    var execCalled = false;
    var re = /a/;
    re.exec = function () { execCalled = true; return null; };
    if (KEY === 'split') {
      // RegExp[@@split] doesn't call the regex's exec method, but first creates
      // a new one. We need to return the patched regex when creating the new one.
      re.constructor = {};
      re.constructor[SPECIES] = function () { return re; };
    }
    re[SYMBOL]('');
    return !execCalled;
  }) : undefined;

  if (
    !DELEGATES_TO_SYMBOL ||
    !DELEGATES_TO_EXEC ||
    (KEY === 'replace' && !REPLACE_SUPPORTS_NAMED_GROUPS) ||
    (KEY === 'split' && !SPLIT_WORKS_WITH_OVERWRITTEN_EXEC)
  ) {
    var nativeRegExpMethod = /./[SYMBOL];
    var fns = exec(
      defined,
      SYMBOL,
      ''[KEY],
      function maybeCallNative(nativeMethod, regexp, str, arg2, forceStringMethod) {
        if (regexp.exec === regexpExec) {
          if (DELEGATES_TO_SYMBOL && !forceStringMethod) {
            // The native String method already delegates to @@method (this
            // polyfilled function), leasing to infinite recursion.
            // We avoid it by directly calling the native @@method method.
            return { done: true, value: nativeRegExpMethod.call(regexp, str, arg2) };
          }
          return { done: true, value: nativeMethod.call(str, regexp, arg2) };
        }
        return { done: false };
      }
    );
    var strfn = fns[0];
    var rxfn = fns[1];

    redefine(String.prototype, KEY, strfn);
    hide(RegExp.prototype, SYMBOL, length == 2
      // 21.2.5.8 RegExp.prototype[@@replace](string, replaceValue)
      // 21.2.5.11 RegExp.prototype[@@split](string, limit)
      ? function (string, arg) { return rxfn.call(string, this, arg); }
      // 21.2.5.6 RegExp.prototype[@@match](string)
      // 21.2.5.9 RegExp.prototype[@@search](string)
      : function (string) { return rxfn.call(string, this); }
    );
  }
};


/***/ }),
/* 56 */,
/* 57 */,
/* 58 */,
/* 59 */,
/* 60 */,
/* 61 */,
/* 62 */,
/* 63 */,
/* 64 */,
/* 65 */,
/* 66 */,
/* 67 */,
/* 68 */,
/* 69 */
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__(24);
var defined = __webpack_require__(15);
// true  -> String#at
// false -> String#codePointAt
module.exports = function (TO_STRING) {
  return function (that, pos) {
    var s = String(defined(that));
    var i = toInteger(pos);
    var l = s.length;
    var a, b;
    if (i < 0 || i >= l) return TO_STRING ? '' : undefined;
    a = s.charCodeAt(i);
    return a < 0xd800 || a > 0xdbff || i + 1 === l || (b = s.charCodeAt(i + 1)) < 0xdc00 || b > 0xdfff
      ? TO_STRING ? s.charAt(i) : a
      : TO_STRING ? s.slice(i, i + 2) : (a - 0xd800 << 10) + (b - 0xdc00) + 0x10000;
  };
};


/***/ }),
/* 70 */
/***/ (function(module, exports, __webpack_require__) {

// getting tag from 19.1.3.6 Object.prototype.toString()
var cof = __webpack_require__(10);
var TAG = __webpack_require__(2)('toStringTag');
// ES3 wrong here
var ARG = cof(function () { return arguments; }()) == 'Arguments';

// fallback for IE11 Script Access Denied error
var tryGet = function (it, key) {
  try {
    return it[key];
  } catch (e) { /* empty */ }
};

module.exports = function (it) {
  var O, T, B;
  return it === undefined ? 'Undefined' : it === null ? 'Null'
    // @@toStringTag case
    : typeof (T = tryGet(O = Object(it), TAG)) == 'string' ? T
    // builtinTag case
    : ARG ? cof(O)
    // ES3 arguments fallback
    : (B = cof(O)) == 'Object' && typeof O.callee == 'function' ? 'Arguments' : B;
};


/***/ }),
/* 71 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var regexpExec = __webpack_require__(29);
__webpack_require__(27)({
  target: 'RegExp',
  proto: true,
  forced: regexpExec !== /./.exec
}, {
  exec: regexpExec
});


/***/ }),
/* 72 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// 21.2.5.3 get RegExp.prototype.flags
var anObject = __webpack_require__(4);
module.exports = function () {
  var that = anObject(this);
  var result = '';
  if (that.global) result += 'g';
  if (that.ignoreCase) result += 'i';
  if (that.multiline) result += 'm';
  if (that.unicode) result += 'u';
  if (that.sticky) result += 'y';
  return result;
};


/***/ }),
/* 73 */,
/* 74 */,
/* 75 */,
/* 76 */,
/* 77 */,
/* 78 */,
/* 79 */,
/* 80 */,
/* 81 */,
/* 82 */,
/* 83 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var anObject = __webpack_require__(4);
var toLength = __webpack_require__(20);
var advanceStringIndex = __webpack_require__(53);
var regExpExec = __webpack_require__(54);

// @@match logic
__webpack_require__(55)('match', 1, function (defined, MATCH, $match, maybeCallNative) {
  return [
    // `String.prototype.match` method
    // https://tc39.github.io/ecma262/#sec-string.prototype.match
    function match(regexp) {
      var O = defined(this);
      var fn = regexp == undefined ? undefined : regexp[MATCH];
      return fn !== undefined ? fn.call(regexp, O) : new RegExp(regexp)[MATCH](String(O));
    },
    // `RegExp.prototype[@@match]` method
    // https://tc39.github.io/ecma262/#sec-regexp.prototype-@@match
    function (regexp) {
      var res = maybeCallNative($match, regexp, this);
      if (res.done) return res.value;
      var rx = anObject(regexp);
      var S = String(this);
      if (!rx.global) return regExpExec(rx, S);
      var fullUnicode = rx.unicode;
      rx.lastIndex = 0;
      var A = [];
      var n = 0;
      var result;
      while ((result = regExpExec(rx, S)) !== null) {
        var matchStr = String(result[0]);
        A[n] = matchStr;
        if (matchStr === '') rx.lastIndex = advanceStringIndex(S, toLength(rx.lastIndex), fullUnicode);
        n++;
      }
      return n === 0 ? null : A;
    }
  ];
});


/***/ }),
/* 84 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function ($, elementor) {
  'use strict';

  var ReaSticky = {
    init: function init() {
      elementor.hooks.addAction('frontend/element_ready/column', ReaSticky.elementorColumn);
      elementorFrontend.hooks.addAction('frontend/element_ready/section', ReaSticky.setStickySection);
      $(ReaSticky.stickySection);
    },
    getStickySectionsDesktop: [],
    getStickySectionsTablet: [],
    getStickySectionsMobile: [],
    setStickySection: function setStickySection($scope) {
      var setStickySection = {
        target: $scope,
        isEditMode: Boolean(elementorFrontend.isEditMode()),
        init: function init() {
          if ('yes' === this.getSectionSetting('rea_sticky_section_sticky')) {
            if (this.isEditMode) {
              $(this.target[0]).addClass('rea-sticky-section-sticky--stuck');
            }

            var availableDevices = this.getSectionSetting('rea_sticky_section_sticky_visibility') || [];

            if (!availableDevices[0]) {
              return;
            }

            if (-1 !== availableDevices.indexOf('desktop')) {
              ReaSticky.getStickySectionsDesktop.push($scope);
            }

            if (-1 !== availableDevices.indexOf('tablet')) {
              ReaSticky.getStickySectionsTablet.push($scope);
            }

            if (-1 !== availableDevices.indexOf('mobile')) {
              ReaSticky.getStickySectionsMobile.push($scope);
            }
          } else {
            if (this.isEditMode) {
              $(this.target[0]).removeClass('rea-sticky-section-sticky--stuck');
            }
          }
        },
        getSectionSetting: function getSectionSetting(setting) {
          var settings = {},
              editMode = Boolean(elementorFrontend.isEditMode());

          if (editMode) {
            if (!elementorFrontend.config.hasOwnProperty('elements')) {
              return;
            }

            if (!elementorFrontend.config.elements.hasOwnProperty('data')) {
              return;
            }

            var modelCID = this.target.data('model-cid'),
                editorSectionData = elementorFrontend.config.elements.data[modelCID];

            if (!editorSectionData) {
              return;
            }

            if (!editorSectionData.hasOwnProperty('attributes')) {
              return;
            }

            settings = editorSectionData.attributes || {};
          } else {
            settings = this.target.data('settings') || {};
          }

          if (!settings[setting]) {
            return;
          }

          return settings[setting];
        }
      };
      setStickySection.init();
    },
    stickySection: function stickySection() {
      var stickySection = {
        isEditMode: Boolean(elementorFrontend.isEditMode()),
        correctionSelector: $('#wpadminbar'),
        initDesktop: false,
        initTablet: false,
        initMobile: false,
        init: function init() {
          this.run();
          $(window).on('resize.ReaStickySectionSticky orientationchange.ReaStickySectionSticky', this.run.bind(this));
        },
        getOffset: function getOffset() {
          var offset = 0;

          if (this.correctionSelector[0] && 'fixed' === this.correctionSelector.css('position')) {
            offset = this.correctionSelector.outerHeight(true);
          }

          return offset;
        },
        run: function run() {
          var currentDeviceMode = elementorFrontend.getCurrentDeviceMode(),
              transitionIn = 'rea-sticky-transition-in',
              transitionOut = 'rea-sticky-transition-out',
              options = {
            stickyClass: 'rea-sticky-section-sticky--stuck',
            topSpacing: this.getOffset()
          };

          function initSticky(section, options) {
            section.jetStickySection(options).on('jetStickySection:stick', function (event) {
              $(event.target).addClass(transitionIn);
              setTimeout(function () {
                $(event.target).removeClass(transitionIn);
              }, 3000);
            }).on('jetStickySection:unstick', function (event) {
              $(event.target).addClass(transitionOut);
              setTimeout(function () {
                $(event.target).removeClass(transitionOut);
              }, 3000);
            });
            section.trigger('jetStickySection:activated');
          }

          if ('desktop' === currentDeviceMode && !this.initDesktop) {
            if (this.initTablet) {
              ReaSticky.getStickySectionsTablet.forEach(function (section, i) {
                section.trigger('jetStickySection:detach');
              });
              this.initTablet = false;
            }

            if (this.initMobile) {
              ReaSticky.getStickySectionsMobile.forEach(function (section, i) {
                section.trigger('jetStickySection:detach');
              });
              this.initMobile = false;
            }

            if (ReaSticky.getStickySectionsDesktop[0]) {
              ReaSticky.getStickySectionsDesktop.forEach(function (section, i) {
                if (ReaSticky.getStickySectionsDesktop[i + 1]) {
                  options.stopper = ReaSticky.getStickySectionsDesktop[i + 1];
                } else {
                  options.stopper = '';
                }

                initSticky(section, options);
              });
              this.initDesktop = true;
            }
          }

          if ('tablet' === currentDeviceMode && !this.initTablet) {
            if (this.initDesktop) {
              ReaSticky.getStickySectionsDesktop.forEach(function (section, i) {
                section.trigger('jetStickySection:detach');
              });
              this.initDesktop = false;
            }

            if (this.initMobile) {
              ReaSticky.getStickySectionsMobile.forEach(function (section, i) {
                section.trigger('jetStickySection:detach');
              });
              this.initMobile = false;
            }

            if (ReaSticky.getStickySectionsTablet[0]) {
              ReaSticky.getStickySectionsTablet.forEach(function (section, i) {
                if (ReaSticky.getStickySectionsTablet[i + 1]) {
                  options.stopper = ReaSticky.getStickySectionsTablet[i + 1];
                } else {
                  options.stopper = '';
                }

                initSticky(section, options);
              });
              this.initTablet = true;
            }
          }

          if ('mobile' === currentDeviceMode && !this.initMobile) {
            if (this.initDesktop) {
              ReaSticky.getStickySectionsDesktop.forEach(function (section, i) {
                section.trigger('jetStickySection:detach');
              });
              this.initDesktop = false;
            }

            if (this.initTablet) {
              ReaSticky.getStickySectionsTablet.forEach(function (section, i) {
                section.trigger('jetStickySection:detach');
              });
              this.initTablet = false;
            }

            if (ReaSticky.getStickySectionsMobile[0]) {
              ReaSticky.getStickySectionsMobile.forEach(function (section, i) {
                if (ReaSticky.getStickySectionsMobile[i + 1]) {
                  options.stopper = ReaSticky.getStickySectionsMobile[i + 1];
                } else {
                  options.stopper = '';
                }

                initSticky(section, options);
              });
              this.initMobile = true;
            }
          }
        }
      };
      stickySection.init();
    }
  };
  $(window).on('elementor/frontend/init', ReaSticky.init);
})(jQuery, window.elementorFrontend);

/***/ }),
/* 85 */,
/* 86 */,
/* 87 */,
/* 88 */,
/* 89 */,
/* 90 */,
/* 91 */,
/* 92 */,
/* 93 */,
/* 94 */,
/* 95 */,
/* 96 */,
/* 97 */,
/* 98 */,
/* 99 */,
/* 100 */,
/* 101 */,
/* 102 */,
/* 103 */,
/* 104 */,
/* 105 */,
/* 106 */,
/* 107 */,
/* 108 */,
/* 109 */,
/* 110 */,
/* 111 */,
/* 112 */,
/* 113 */,
/* 114 */,
/* 115 */,
/* 116 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(117);

__webpack_require__(119);

__webpack_require__(84);

/***/ }),
/* 117 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _interopRequireDefault = __webpack_require__(42);

__webpack_require__(39);

var _baseSlider = _interopRequireDefault(__webpack_require__(118));

var MediaCarouselHandler;
MediaCarouselHandler = _baseSlider.default.extend({
  slideshowSpecialElementSettings: ['rea_slides_per_view', 'rea_slides_per_view_tablet', 'rea_slides_per_view_mobile'],
  isSlideshow: function isSlideshow() {
    return 'slideshow' === this.getElementSettings('rea_skin');
  },
  getDefaultSettings: function getDefaultSettings() {
    var defaultSettings = _baseSlider.default.prototype.getDefaultSettings.apply(this, arguments);

    if (this.isSlideshow()) {
      defaultSettings.selectors.thumbsSwiper = '.rea-elementor-thumbnails-swiper';
      defaultSettings.slidesPerView = {
        desktop: 5,
        tablet: 4,
        mobile: 3
      };
    }

    return defaultSettings;
  },
  getElementSettings: function getElementSettings(setting) {
    if (-1 !== this.slideshowSpecialElementSettings.indexOf(setting) && this.isSlideshow()) {
      setting = 'rea_slideshow_' + setting;
    }

    return _baseSlider.default.prototype.getElementSettings.call(this, setting);
  },
  getDefaultElements: function getDefaultElements() {
    var selectors = this.getSettings('selectors'),
        defaultElements = _baseSlider.default.prototype.getDefaultElements.apply(this, arguments);

    if (this.isSlideshow()) {
      defaultElements.$thumbsSwiper = this.$element.find(selectors.thumbsSwiper);
    }

    return defaultElements;
  },
  getEffect: function getEffect() {
    if ('coverflow' === this.getElementSettings('rea_skin')) {
      return 'coverflow';
    }

    return _baseSlider.default.prototype.getEffect.apply(this, arguments);
  },
  getSlidesPerView: function getSlidesPerView(device) {
    if (this.isSlideshow()) {
      return 1;
    }

    if ('coverflow' === this.getElementSettings('rea_skin')) {
      return this.getDeviceSlidesPerView(device);
    }

    return _baseSlider.default.prototype.getSlidesPerView.apply(this, arguments);
  },
  getSwiperOptions: function getSwiperOptions() {
    var options = _baseSlider.default.prototype.getSwiperOptions.apply(this, arguments);

    if (this.isSlideshow()) {
      options.loopedSlides = this.getSlidesCount();
      delete options.pagination;
      delete options.breakpoints;
    }

    return options;
  },
  onInit: function onInit() {
    _baseSlider.default.prototype.onInit.apply(this, arguments);

    var slidesCount = this.getSlidesCount();

    if (!this.isSlideshow() || 1 >= slidesCount) {
      return;
    }

    var elementSettings = this.getElementSettings(),
        loop = 'yes' === elementSettings.rea_loop,
        breakpointsSettings = {},
        breakpoints = elementorFrontend.config.breakpoints,
        desktopSlidesPerView = this.getDeviceSlidesPerView('desktop');
    breakpointsSettings[breakpoints.lg - 1] = {
      slidesPerView: this.getDeviceSlidesPerView('tablet'),
      spaceBetween: this.getSpaceBetween('tablet')
    };
    breakpointsSettings[breakpoints.md - 1] = {
      slidesPerView: this.getDeviceSlidesPerView('mobile'),
      spaceBetween: this.getSpaceBetween('mobile')
    };
    var thumbsSliderOptions = {
      slidesPerView: desktopSlidesPerView,
      initialSlide: this.getInitialSlide(),
      centeredSlides: elementSettings.rea_centered_slides,
      slideToClickedSlide: true,
      spaceBetween: this.getSpaceBetween(),
      loopedSlides: slidesCount,
      loop: loop,
      breakpoints: breakpointsSettings,
      handleElementorBreakpoints: true
    };
    this.Swipers.main.controller.control = this.Swipers.thumbs = new Swiper(this.elements.$thumbsSwiper, thumbsSliderOptions);
    this.elements.$thumbsSwiper.data('swiper', this.Swipers.thumbs);
    this.Swipers.thumbs.controller.control = this.Swipers.main;
  },
  onElementChange: function onElementChange(propertyName) {
    if (1 >= this.getSlidesCount()) {
      return;
    }

    if (!this.isSlideshow()) {
      _baseSlider.default.prototype.onElementChange.apply(this, arguments);

      return;
    }

    if (0 === propertyName.indexOf('width')) {
      this.Swipers.main.update();
      this.Swipers.thumbs.update();
    }

    if (0 === propertyName.indexOf('rea_space_between')) {
      this.updateSpaceBetween(this.Swipers.thumbs, propertyName);
    }
  }
});
jQuery(window).on("elementor/frontend/init", function () {
  var addHandler = function addHandler($scope) {
    elementorFrontend.elementsHandler.addHandler(MediaCarouselHandler, {
      $element: $scope
    });
  };

  elementorFrontend.hooks.addAction("frontend/element_ready/rea-media-carousel.default", addHandler);
});

/***/ }),
/* 118 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(83);

__webpack_require__(39);

var Base;
Base = elementorModules.frontend.handlers.Base.extend({
  getDefaultSettings: function getDefaultSettings() {
    return {
      selectors: {
        mainSwiper: '.elementor-main-swiper',
        swiperSlide: '.swiper-slide'
      },
      slidesPerView: {
        desktop: 3,
        tablet: 2,
        mobile: 1
      }
    };
  },
  getDefaultElements: function getDefaultElements() {
    var selectors = this.getSettings('selectors');
    var elements = {
      $mainSwiper: this.$element.find(selectors.mainSwiper)
    };
    elements.$mainSwiperSlides = elements.$mainSwiper.find(selectors.swiperSlide);
    return elements;
  },
  getSlidesCount: function getSlidesCount() {
    return this.elements.$mainSwiperSlides.length;
  },
  getInitialSlide: function getInitialSlide() {
    var editSettings = this.getEditSettings();
    return editSettings.activeItemIndex ? editSettings.activeItemIndex - 1 : 0;
  },
  getEffect: function getEffect() {
    return this.getElementSettings('rea_effect');
  },
  getDeviceSlidesPerView: function getDeviceSlidesPerView(device) {
    var slidesPerViewKey = 'rea_slides_per_view' + ('desktop' === device ? '' : '_' + device);
    return Math.min(this.getSlidesCount(), +this.getElementSettings(slidesPerViewKey) || this.getSettings('slidesPerView')[device]);
  },
  getSlidesPerView: function getSlidesPerView(device) {
    if ('slide' === this.getEffect()) {
      return this.getDeviceSlidesPerView(device);
    }

    return 1;
  },
  getDesktopSlidesPerView: function getDesktopSlidesPerView() {
    return this.getSlidesPerView('desktop');
  },
  getTabletSlidesPerView: function getTabletSlidesPerView() {
    return this.getSlidesPerView('tablet');
  },
  getMobileSlidesPerView: function getMobileSlidesPerView() {
    return this.getSlidesPerView('mobile');
  },
  getDeviceSlidesToScroll: function getDeviceSlidesToScroll(device) {
    var slidesToScrollKey = 'rea_slides_to_scroll' + ('desktop' === device ? '' : '_' + device);
    return Math.min(this.getSlidesCount(), +this.getElementSettings(slidesToScrollKey) || 1);
  },
  getSlidesToScroll: function getSlidesToScroll(device) {
    if ('slide' === this.getEffect()) {
      return this.getDeviceSlidesToScroll(device);
    }

    return 1;
  },
  getDesktopSlidesToScroll: function getDesktopSlidesToScroll() {
    return this.getSlidesToScroll('desktop');
  },
  getTabletSlidesToScroll: function getTabletSlidesToScroll() {
    return this.getSlidesToScroll('tablet');
  },
  getMobileSlidesToScroll: function getMobileSlidesToScroll() {
    return this.getSlidesToScroll('mobile');
  },
  getSpaceBetween: function getSpaceBetween(device) {
    var propertyName = 'rea_space_between';

    if (device && 'desktop' !== device) {
      propertyName += '_' + device;
    }

    return this.getElementSettings(propertyName).size || 0;
  },
  getSwiperOptions: function getSwiperOptions() {
    var elementSettings = this.getElementSettings(); // TODO: Temp migration for old saved values since 2.2.0

    if ('progress' === elementSettings.rea_pagination) {
      elementSettings.rea_pagination = 'progressbar';
    }

    var swiperOptions = {
      grabCursor: true,
      initialSlide: this.getInitialSlide(),
      slidesPerView: this.getDesktopSlidesPerView(),
      slidesPerGroup: this.getDesktopSlidesToScroll(),
      spaceBetween: this.getSpaceBetween(),
      loop: 'yes' === elementSettings.rea_loop,
      speed: elementSettings.rea_speed,
      effect: this.getEffect(),
      preventClicksPropagation: false,
      slideToClickedSlide: true,
      handleElementorBreakpoints: true
    };

    if (elementSettings.rea_show_arrows) {
      swiperOptions.navigation = {
        prevEl: '.elementor-swiper-button-prev',
        nextEl: '.elementor-swiper-button-next'
      };
    }

    if (elementSettings.rea_pagination) {
      swiperOptions.pagination = {
        el: '.swiper-pagination',
        type: elementSettings.rea_pagination,
        clickable: true
      };
    }

    if ('cube' !== this.getEffect()) {
      var breakpointsSettings = {},
          breakpoints = elementorFrontend.config.breakpoints;
      breakpointsSettings[breakpoints.lg - 1] = {
        slidesPerView: this.getTabletSlidesPerView(),
        slidesPerGroup: this.getTabletSlidesToScroll(),
        spaceBetween: this.getSpaceBetween('tablet')
      };
      breakpointsSettings[breakpoints.md - 1] = {
        slidesPerView: this.getMobileSlidesPerView(),
        slidesPerGroup: this.getMobileSlidesToScroll(),
        spaceBetween: this.getSpaceBetween('mobile')
      };
      swiperOptions.breakpoints = breakpointsSettings;
    }

    if (!this.isEdit && elementSettings.rea_autoplay) {
      swiperOptions.autoplay = {
        delay: elementSettings.rea_autoplay_speed,
        disableOnInteraction: !!elementSettings.rea_pause_on_interaction
      };
    }

    return swiperOptions;
  },
  updateSpaceBetween: function updateSpaceBetween(swiper, propertyName) {
    var deviceMatch = propertyName.match('rea_space_between_(.*)'),
        device = deviceMatch ? deviceMatch[1] : 'desktop',
        newSpaceBetween = this.getSpaceBetween(device),
        breakpoints = elementorFrontend.config.breakpoints;

    if ('desktop' !== device) {
      var breakpointDictionary = {
        tablet: breakpoints.lg - 1,
        mobile: breakpoints.md - 1
      };
      swiper.params.breakpoints[breakpointDictionary[device]].spaceBetween = newSpaceBetween;
    } else {
      swiper.originalParams.spaceBetween = newSpaceBetween;
    }

    swiper.params.spaceBetween = newSpaceBetween;
    swiper.update();
  },
  onInit: function onInit() {
    var _this = this;

    elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
    var elementSettings = this.getElementSettings();
    this.Swipers = {};

    if (1 >= this.getSlidesCount()) {
      return;
    }

    this.Swipers.main = new Swiper(this.elements.$mainSwiper, this.getSwiperOptions()); // Expose the swiper instance in the frontend

    this.elements.$mainSwiper.data('swiper', this.Swipers.main);

    if (elementSettings.rea_pause_on_hover) {
      this.elements.$mainSwiper.on({
        mouseenter: function mouseenter() {
          _this.Swipers.main.autoplay.stop();
        },
        mouseleave: function mouseleave() {
          _this.Swipers.main.autoplay.start();
        }
      });
    }
  },
  onElementChange: function onElementChange(propertyName) {
    if (1 >= this.getSlidesCount()) {
      return;
    }

    if (0 === propertyName.indexOf('width')) {
      this.Swipers.main.update();
    }

    if (0 === propertyName.indexOf('rea_space_between')) {
      this.updateSpaceBetween(this.Swipers.main, propertyName);
    }
  },
  onEditSettingsChange: function onEditSettingsChange(propertyName) {
    if (1 >= this.getSlidesCount()) {
      return;
    }

    if ('activeItemIndex' === propertyName) {
      this.Swipers.main.slideToLoop(this.getEditSettings('activeItemIndex') - 1);
    }
  }
});
module.exports = Base;

/***/ }),
/* 119 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function ($) {
  "use strict";

  $(document).ready(function () {
    if ($(".rea-video-popup").length > 0) {
      $(".rea-video-popup").magnificPopup({
        type: "iframe",
        mainClass: "mfp-fade",
        removalDelay: 160,
        preloader: !0,
        fixedContentPos: !1
      });
    }
  });
})(jQuery);

/***/ })
/******/ ]);
//# sourceMappingURL=frontend.js.map