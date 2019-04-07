export function replaceSpecialGermanChars(str) {
    const ul = ['ä', 'ö', 'ü', 'ß']
    const repl = ['ae', 'oe', 'ue', 'ss']
    for (let i = 0; i < ul.length; i++) {
        let rgx = new RegExp(ul[i], 'g')
        str = str.replace(rgx, repl[i])
    }
    return str
}
