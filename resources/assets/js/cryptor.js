'use strict';

const Base64 = require('crypto-js/enc-base64');

const Hex = require('crypto-js/enc-hex');

const AES = require('crypto-js/aes');

const Uft8 = require('crypto-js/enc-utf8');

const Lib = require('crypto-js/lib-typedarrays');

const salt = 'a09ea7653e931cb1f3e55266cd7495c3fede0d29';

/**
* AES JSON formatter for CryptoJS
*
* @author BrainFooLong (bfldev.com)
* @link https://github.com/brainfoolong/cryptojs-aes-php
*/

const CryptoJSAesJson = {

  stringify: function (cipherParams) {

    var j = {ct: cipherParams.ciphertext.toString(Base64)};
    if (cipherParams.iv) j.iv = cipherParams.iv.toString();
    if (cipherParams.salt) j.s = cipherParams.salt.toString();
    return JSON.stringify(j);

  },

  parse: function (jsonStr) {

    var j = JSON.parse(jsonStr);
    var cipherParams = Lib.CipherParams.create({ciphertext: Base64.parse(j.ct)});
    if (j.iv) cipherParams.iv = Hex.parse(j.iv);
    if (j.s) cipherParams.salt = Hex.parse(j.s);
    return cipherParams;

  }

}

/**
* Encrypt a string with Crypto-JS
* @return String
*/
window.jsencrypt = function (e) {

  return AES.encrypt(JSON.stringify(e), salt, {format: CryptoJSAesJson}).toString();

}

/**
* Decrypt an encrypted string with Crypto-JS
* @return String
*/
window.jsdecrypt = function (e) {

  return JSON.parse(AES.decrypt(e, salt, {format: CryptoJSAesJson}).toString(Utf8));

}
