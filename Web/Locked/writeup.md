# Locked

There is a top secret section with contents:
```js
// This is the secret code.
const topSecret = [][(![] + [])[+[]] + (![] + []) ...;
```
which is just esoteric javascript called JSFuck. The value of the variable `topSecret` can be found from the browser's developer console:

![](https://i.imgur.com/uROG6Va.png)

So the value of `topSecret` is: `MTAzMTA0MTI1MTAzMTMxMDUxMTAzMTExMTE4MTIzMTAyMDU3MTI1MTAyMDc2MDk4MTExMDkyMDk2MDc4MDg3MDkyMDQyMTI2`

Next, there is a secret section with contents:
```js
// This is the secret function that makes the magic happen.
function _0x1ddf() { const _0xea79a7 = ['.combination-input\x20.text-value', topSecret, 'push', 'test', 'querySelectorAll', 'innerHTML', 'length', 'substring']; _0x1ddf = function () { return _0xea79a7; }; return _0x1ddf(); } function _0x2fa4(_0x23e008, _0x1ddf5b) { const _0x2fa47e = _0x1ddf(); _0x2fa4 = function (_0xdcdc6d, _0x45af50) { _0xdcdc6d = _0xdcdc6d - 0x142; let _0x4b01ea = _0x2fa47e[_0xdcdc6d]; return _0x4b01ea; }; return _0x2fa4(_0x23e008, _0x1ddf5b); } const checkCombination = () => { const _0xd2e73a = _0x2fa4; const _0x5b8a57 = document[_0xd2e73a('0x146')](_0xd2e73a('0x142')); let _0x257e75 = []; for (let _0x2b6a26 = 0x0; _0x2b6a26 < _0x5b8a57[_0xd2e73a('0x148')]; _0x2b6a26++) { _0x257e75[_0xd2e73a('0x144')](parseInt(_0x5b8a57[_0x2b6a26][_0xd2e73a('0x147')])); } let _0x4e272b = _0xd2e73a('0x143'); let _0x4f5ec8 = atob(_0x4e272b); let _0x27a1c7 = []; for (let _0x3c8f0c = 0x0; _0x3c8f0c < _0x4f5ec8[_0xd2e73a('0x148')]; _0x3c8f0c += 0x3) { _0x27a1c7[_0xd2e73a('0x144')](_0x4f5ec8[_0xd2e73a('0x149')](_0x3c8f0c, _0x3c8f0c + 0x3)); } let _0x36dcd7 = []; for (let _0x2ad64e = 0x0; _0x2ad64e < 0x18; _0x2ad64e++) { _0x36dcd7[_0xd2e73a('0x144')](_0x27a1c7[_0x2ad64e] - _0x257e75[_0x2ad64e % _0x257e75[_0xd2e73a('0x148')]]); } let _0x25ee92 = String['fromCharCode']['apply'](null, _0x36dcd7); if (/^dctf\{.*\}$/[_0xd2e73a('0x145')](_0x25ee92)) { text = _0x25ee92; return !![]; } else { return ![]; } };
```

The first thing to notice is that the code is obfuscated. So, let's clean the code up a bit using some tool like https://beautifier.io:

```js
function _0x1ddf() {
    const _0xea79a7 = ['.combination-input\x20.text-value', topSecret, 'push', 'test', 'querySelectorAll', 'innerHTML', 'length', 'substring'];
    _0x1ddf = function() {
        return _0xea79a7;
    };
    return _0x1ddf();
}

function _0x2fa4(_0x23e008, _0x1ddf5b) {
    const _0x2fa47e = _0x1ddf();
    _0x2fa4 = function(_0xdcdc6d, _0x45af50) {
        _0xdcdc6d = _0xdcdc6d - 0x142;
        let _0x4b01ea = _0x2fa47e[_0xdcdc6d];
        return _0x4b01ea;
    };
    return _0x2fa4(_0x23e008, _0x1ddf5b);
}
const checkCombination = () => {
    const _0xd2e73a = _0x2fa4;
    const _0x5b8a57 = document[_0xd2e73a('0x146')](_0xd2e73a('0x142'));
    let _0x257e75 = [];
    for (let _0x2b6a26 = 0x0; _0x2b6a26 < _0x5b8a57[_0xd2e73a('0x148')]; _0x2b6a26++) {
        _0x257e75[_0xd2e73a('0x144')](parseInt(_0x5b8a57[_0x2b6a26][_0xd2e73a('0x147')]));
    }
    let _0x4e272b = _0xd2e73a('0x143');
    let _0x4f5ec8 = atob(_0x4e272b);
    let _0x27a1c7 = [];
    for (let _0x3c8f0c = 0x0; _0x3c8f0c < _0x4f5ec8[_0xd2e73a('0x148')]; _0x3c8f0c += 0x3) {
        _0x27a1c7[_0xd2e73a('0x144')](_0x4f5ec8[_0xd2e73a('0x149')](_0x3c8f0c, _0x3c8f0c + 0x3));
    }
    let _0x36dcd7 = [];
    for (let _0x2ad64e = 0x0; _0x2ad64e < 0x18; _0x2ad64e++) {
        _0x36dcd7[_0xd2e73a('0x144')](_0x27a1c7[_0x2ad64e] - _0x257e75[_0x2ad64e % _0x257e75[_0xd2e73a('0x148')]]);
    }
    let _0x25ee92 = String['fromCharCode']['apply'](null, _0x36dcd7);
    if (/^dctf\{.*\}$/ [_0xd2e73a('0x145')](_0x25ee92)) {
        text = _0x25ee92;
        return !![];
    } else {
        return ![];
    }
};
```

There are functions like _0x1ddf and _0x2fa4 that are used to obfuscate the code. Also we see that there are numerous calls of the pattern `_0xd2e73a(<Some Hexadecimal value>)`. Also notice the statement `const _0xd2e73a = _0x2fa4;`. So we can find the values of those function calls from the console and replace them with the actual values.

For example:

`_0xd2e73a('0x146')` can be changed to `_0x2fa4('0x146')` and executed in the console:
![](https://i.imgur.com/0aKbwkN.png)

Replacing all the function calls with the actual values we get:

```js
const checkCombination = () => {
    const _0xd2e73a = _0x2fa4;
    const _0x5b8a57 = document['querySelectorAll']('.combination-input\x20.text-value');
    let _0x257e75 = [];
    for (let _0x2b6a26 = 0x0; _0x2b6a26 < _0x5b8a57['length']; _0x2b6a26++) {
        _0x257e75['push'](parseInt(_0x5b8a57[_0x2b6a26]['innerHTML']));
    }
    let _0x4e272b = topSecret;
    let _0x4f5ec8 = atob(_0x4e272b);
    let _0x27a1c7 = [];
    for (let _0x3c8f0c = 0x0; _0x3c8f0c < _0x4f5ec8['length']; _0x3c8f0c += 0x3) {
        _0x27a1c7['push'](_0x4f5ec8['substring'](_0x3c8f0c, _0x3c8f0c + 0x3));
    }
    let _0x36dcd7 = [];
    for (let _0x2ad64e = 0x0; _0x2ad64e < 0x18; _0x2ad64e++) {
        _0x36dcd7['push'](_0x27a1c7[_0x2ad64e] - _0x257e75[_0x2ad64e % _0x257e75['length']]);
    }
    let _0x25ee92 = String['fromCharCode']['apply'](null, _0x36dcd7);
    if (/^dctf\{.*\}$/ ['test'](_0x25ee92)) {
        text = _0x25ee92;
        return !![];
    } else {
        return ![];
    }
};
```

Now let's cleanup the code by renaming the cryptic variable names (you can open the code in some IDE and use the rename feature to make life easier):

```js
const checkCombination = () => {
    const combinationInputValue = document['querySelectorAll']('.combination-input .text-value');
    let list1 = [];
    for (let i = 0; i < combinationInputValue['length']; i++) {
        list1['push'](parseInt(combinationInputValue[i]['innerHTML']));
    }
    let base64DecodedSecret = atob(topSecret);
    let list2 = [];
    for (let j = 0; j < base64decodedSecret['length']; j += 3) {
        list2['push'](base64decodedSecret['substring'](j, j + 3));
    }
    let list3 = [];
    for (let k = 0; k < 24; k++) {
        list3['push'](list2[k] - list1[k % list1['length']]);
    }
    let someString = String['fromCharCode']['apply'](null, list3);
    if (/^dctf\{.*\}$/ ['test'](someString)) {
        text = someString;
        return !![];
    } else {
        return ![];
    }
};
```

Now the code is much more readable. We also notice that object property accesses and object method calls are obfuscated as subscripts (which are legal in javascript). For instance `base64decodedSecret.length` is obfuscated as `base64decodedSecret['length']`.
We can clean instances of those subscripts as well:

```js
const checkCombination = () => {
    const combinationInputValue = document.querySelectorAll('.combination-input .text-value');
    let list1 = [];
    for (let i = 0; i < combinationInputValue.length; i++) {
        list1.push(parseInt(combinationInputValue[i]['innerHTML']));
    }
    let base64DecodedSecret = atob(topSecret);
    let list2 = [];
    for (let j = 0; j < base64decodedSecret.length; j += 3) {
        list2.push(base64decodedSecret.substring(j, j + 3));
    }
    let list3 = [];
    for (let k = 0; k < 24; k++) {
        list3.push(list2[k] - list1[k % list1.length]);
    }
    let someString = String.fromCharCode.apply(null, list3);
    if (/^dctf\{.*\}$/.test(someString)) {
        text = someString;
        return true;
    } else {
        return false;
    }
};
```

Now that we have a vague idea of what the code is trying to accomplish, we can start to rename the variables in a more meaningful way. Also we can replace `atob(topSecret)` with the actual value:

![](https://i.imgur.com/KHdaL1V.png)

Also notice that `someString` is the flag.

Also let's simplify the code further:

```js
const checkCombination = () => {
    const combinationInputValue = document.querySelectorAll('.combination-input .text-value');
    let combinationValues = [];
    for (let i = 0; i < combinationInputValue.length; i++) {
        combinationValues.push(parseInt(combinationInputValue[i]['innerHTML']));
    }
    let listOfAsciiCodes = ["103", "104", "125", "103", "131", "051", "103", "111", "118", "123", "102", "057", "125", "102", "076", "098", "111", "092", "096", "078", "087", "092", "042", "126"];
    let asciiCodes = [];
    for (let k = 0; k < 24; k++) {
        asciiCodes.push(listOfCharacters[k] - combinationValues[k % combinationValues.length]);
    }
    let flag = String.fromCharCode.apply(null, asciiCodes);
    if (/^dctf\{.*\}$/.test(flag)) {
        text = flag;
        return true;
    } else {
        return false;
    }
};
```

From this we can see that the `listOfAsciiCodes` are offset by the values of the combination inputs. But we know the first 5 characters of the flag: "dctf{", which correspond to the ascii values: 100, 99, 116, 102, 123. So, comparing the first five values of `listOfAsciiCodes`, `["103", "104", "125", "103", "131"...]` with the ascii values of the flag, we get the offsets: (3, 5, 9, 1, 8), which is the value of the combination lock.

Entering the values in the combination lock, we get the flag:

![](https://i.imgur.com/LtDqYiu.png)
