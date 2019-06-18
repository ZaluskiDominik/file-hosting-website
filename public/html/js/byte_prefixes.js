//storage capacity prefixes
const KB = 1024;
const MB = KB * 1024;
const GB = MB * 1024;

function round(number, numDigitsAfterDot)
{
    let power10 = Math.pow(10, numDigitsAfterDot);
    return (Math.round(number * power10) / power10).toFixed(numDigitsAfterDot);
}