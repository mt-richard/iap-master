const log = console.log.bind(document);
const mergeTwoArrays = (array1, array2) => array1.concat(array2);
const mergeTwoObjects = (ob1, ob2) => {
  const two = { ...ob1, ...ob2 };
  return two;
};
const isNum = (n) => !isNaN(parseFloat(n)) && isFinite(n);
const isStr = (value) => typeof value === "string";
const isNull = (value) => value === null || value === undefined;
const delDuplicates = (array) => [...new Set(array)];
const hasValue = (elId) => {
  var myInput = document.getElementById(`${elId}`);
  if (myInput && myInput.value) return true;
  return false;
};
const limitKeypress = (event, value, maxLength) => {
  if (value != undefined && value.toString().length >= maxLength) {
    event.preventDefault();
  }
};
function validatePhoneNumber(input_str) {
  var re = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
  return re.test(input_str);
}
function isEmail(email) {
  return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(
    email
  );
}
const sendWithAjax = async (inputData, url = "users") => {
  const rawResponse = await fetch(`${url}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `${inputData}`,
  });
  let content = await rawResponse.text();
  try {
    let c = JSON.parse(content);
    content = c;
  } catch (error) {
    content = { isOk: false, data: JSON.stringify(content) };
  }
  if (content.isOk) {
    return {
      isOk: true,
      data: content.data,
      extra: content,
    };
  }
  return {
    isOk: false,
    data: content.data,
  };
};
const toggleMyClass = (idOrClass = "#checkboxes", className = "d-block") => {
  $(`${idOrClass}`).toggleClass(`${className}`);
};
const objHasKey = (myObj, key) => {
  return Object.prototype.hasOwnProperty.call(myObj, `${key}`);
};
