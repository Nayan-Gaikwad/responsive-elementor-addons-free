QUnit.module("Set title", function(hooks) {
    hooks.beforeEach(function() {
        var fixture = document.getElementById('qunit-fixture');
        fixture.innerHTML = '<div id="pageTitle"></div>';
    });

    QUnit.module('with 1 - 5 names', function() {
        QUnit.test('John, Faiza and Stan', function(assert) {
            setTitle(['John', 'Faiza', 'Stan']);
            var title = document.getElementById('pageTitle').innerText;
            assert.equal(title, 'John, Faiza and Stan');
        });

        QUnit.test('John and Faiza', function(assert) {
            setTitle(['John', 'Faiza']);
            var title = document.getElementById('pageTitle').innerText;
            assert.equal(title, 'John and Faiza');
        });

        QUnit.test('John', function(assert) {
            setTitle(['John']);
            var title = document.getElementById('pageTitle').innerText;
            assert.equal(title, 'John');
        });
    });

    QUnit.module('with more than 5 names', function() {
        QUnit.test('John, Faiza, Stan, Isabel, Sven, Anna, Elsa', function(assert) {
            setTitle(['John', 'Faiza', 'Stan', 'Isabel', 'Sven', 'Anna', 'Elsa']);
            var title = document.getElementById('pageTitle').innerText;
            assert.equal(title, 'John, Faiza, Stan, Isabel, Sven and 2 more');
        });
    });
});