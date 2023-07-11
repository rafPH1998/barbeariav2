export function formatDate(inputValue) {
    let formattedValue = inputValue.replace(/\D/g, '');
  
    if (formattedValue.length > 8) {
      formattedValue = formattedValue.slice(0, 8);
    }
  
    if (formattedValue.length > 2) {
      formattedValue =
        formattedValue.substr(0, 2) +
        '/' +
        formattedValue.substr(2, 2) +
        '/' +
        formattedValue.substr(4);
    }
  
    return formattedValue;
}
  