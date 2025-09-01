/* global Cypress, cy */

module.exports = {
  text(length) {
    length = length || 10;
    let text = '';
    const possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    for (let i = 0; i < length; i++) {
      text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
  },

  fulltext(length) {
    length = length || 10;
    let fulltext = '';
    const possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789'
    + "!@#$%^&*";
    // + "`!@#$%^&*()_+-=;:'<>/?,.";
    for (let i = 0; i < length; i++) {
      fulltext += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return fulltext;
  },

  fulltextPass(length) {
    length = length || 10;
    let fulltext = '';
    const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const lowercase = 'abcdefghijklmnopqrstuvwxyz';
    const numbers = '123456789';
    const chars = "!@#$%^&*";

    const possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789'
    + "!@#$%^&*";
    // + "`!@#$%^&*()_+-=;:'<>/?,.";

    fulltext += uppercase.charAt(Math.floor(Math.random() * uppercase.length));
    fulltext += lowercase.charAt(Math.floor(Math.random() * lowercase.length));
    fulltext += numbers.charAt(Math.floor(Math.random() * numbers.length));
    fulltext += chars.charAt(Math.floor(Math.random() * chars.length));

    for (let i = fulltext.length; i < length; i++) {
      fulltext += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return fulltext;
  },

  textLowerCaseAndNumbers(length) {
    length = length || 10;
    let text = '';
    const possible = 'abcdefghijklmnopqrstuvwxyz0123456789';
    for (let i = 0; i < length; i++) {
      text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
  },

  number(length) {
    length = length || 5;
    let number = '';
    const possible = '0123456789';
    for (let i = 0; i < length; i++) {
      number += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return number;
  },

  numberBetweenTwoNumbers(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  },

  emoticons(length) {
    length = length || 5;
    let index;
    let emoticon = '';
    const possibleArr = ['😀', '😂', '😃', '😎', '😉', '😊', '😜', '🐶', '🐱'];
    for (let i = 0; i < length; i++) {
      index = Math.floor(Math.random() * 9);
      emoticon += possibleArr[index];
    }
    return emoticon;
  },
};
