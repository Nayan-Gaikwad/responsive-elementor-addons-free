function setTitle(names) {
    var title = '';
    if (!names) {
        return title;
    } else if (names.length === 1) {
        title = names[0];
    } else if (names.length > 1 && names.length <= 5) {
        var last = names.pop();
        var title = `${names.join(", ")} and ${last}`;
    } else if (names.length > 5) {
        var take = names.splice(0, 5);
        var title = `${take.join(', ')} and ${names.length} more`
    }

    document.getElementById('pageTitle').innerText = title;
}