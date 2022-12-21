function marcaDesmarca(caller) {
    var checks = document.querySelectorAll('input[class="check-notas-pagas-ou-nao"]');    
    checks.forEach(c => c.checked = (c == caller) );
}