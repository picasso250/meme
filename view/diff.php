<style>
ins{
    color:#02710e;
    background-color: #87dba4;
}
del{
    color:red;
    background:#e99;
}
</style>

<script src="../../js/diff.js" type="application/javascript"></script>

<textarea id="a"><?=$a->text?></textarea>
<textarea id="b"><?=$b->text?></textarea>
<pre id="result"></pre>
<script>
var a = document.getElementById('a');
var b = document.getElementById('b');
var result = document.getElementById('result');

function changed() {
	var diff = JsDiff[window.diffType](a.textContent, b.textContent);
	var fragment = document.createDocumentFragment();
	for (var i=0; i < diff.length; i++) {

		if (diff[i].added && diff[i + 1] && diff[i + 1].removed) {
			var swap = diff[i];
			diff[i] = diff[i + 1];
			diff[i + 1] = swap;
		}

		var node;
		if (diff[i].removed) {
			node = document.createElement('del');
			node.appendChild(document.createTextNode(diff[i].value));
		} else if (diff[i].added) {
			node = document.createElement('ins');
			node.appendChild(document.createTextNode(diff[i].value));
		} else {
			node = document.createTextNode(diff[i].value);
		}
		fragment.appendChild(node);
	}

	result.textContent = '';
	result.appendChild(fragment);
}

window.onload = function() {
	onDiffTypeChange(document.querySelector('#settings [name="diff_type"]:checked'));
	changed();
};

a.onpaste = a.onchange =
b.onpaste = b.onchange = changed;

if ('oninput' in a) {
	a.oninput = b.oninput = changed;
} else {
	a.onkeyup = b.onkeyup = changed;
}

function onDiffTypeChange(radio) {
	window.diffType = "diffChars";
	document.title = "Diff " + "diffChars".slice(4);
}

var radio = document.getElementsByName('diff_type');
for (var i = 0; i < radio.length; i++) {
	radio[i].onchange = function(e) {
		onDiffTypeChange(e.target);
		changed();
	}
}
</script>