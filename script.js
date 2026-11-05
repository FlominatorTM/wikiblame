function setFormDate(year, mon, day)
{
	document.forms['mainform'].elements['offjahr'].value = year;
	document.forms['mainform'].elements['offmon'].value = mon;
	document.forms['mainform'].elements['offtag'].value = day;
}

/**
 * Handle the “reset” button.
 * @param {Event} e The click event.
 */
function setFormDateToToday(e)
{
	e.preventDefault();
	var now = new Date();
	setFormDate(now.getFullYear(), now.getMonth()+1, now.getDate());
}

/**
 * Disable submit button when user wants to query too much revisions by linear search.
 */
function checkScanAmount()
{
	var allowedVersionsPerCall = +document.body.getAttribute('data-allowedVersionsPerCall');
	var versionsToQuery = document.forms['mainform'].elements['limit'].value;
	var versionsToSkipDuring = document.forms['mainform'].elements['skipversions'].value;
	var versionsToSkipBeginning = document.forms['mainform'].elements['ignorefirst'].value;
	var expectedVersionsToQuery = versionsToQuery - versionsToSkipBeginning;
	if(versionsToSkipDuring > 0)
	{
		expectedVersionsToQuery = expectedVersionsToQuery / versionsToSkipDuring;
	}

	if(
		allowedVersionsPerCall > -1 && expectedVersionsToQuery > allowedVersionsPerCall &&
		document.forms['mainform'].elements['linear'].checked
	)
	{
		var alertText = i18n.get_less_versions
			.replace(/__ALLOWEDREVISIONS__/g, '' + allowedVersionsPerCall)
			.replace(/__NUMREVISIONS__/g, '' + expectedVersionsToQuery);
		alert(alertText);
		document.forms['mainform'].elements['start'].disabled=true;
	}
	else
	{
		document.forms['mainform'].elements['start'].disabled=false;
	}
}

/**
 * Handle the “from URL” button.
 * @param {Event} e The click event.
 */
async function pasteFieldsFromUrl(e)
{
	e.preventDefault();
	var mediaWikiUrl = window.prompt(i18n.paste_url, '');
	if(mediaWikiUrl == null) return;
	var button = document.getElementById('from_url');
	var label = button.value;
	button.disabled = true;
	button.value = i18n.please_wait;
	try
	{
		var response = await fetch('discover.php?url=' + encodeURIComponent(mediaWikiUrl));
		if(!response.ok) throw new Error('Discovery failed');
		var site = await response.json();
		var hostParts = site.host.split('.');
		var fields = document.forms['mainform'].elements;
		fields.lang.value = hostParts.length == 3 ? hostParts.shift() : 'blank';
		fields.tld.value = hostParts.pop();
		fields.project.value = hostParts.join('.');
		fields.article.value = site.title;
		fields.wiki_paths.value = JSON.stringify(site.paths);
	}
	catch(error)
	{
		alert(i18n.discovery_failed);
	}
	finally
	{
		button.disabled = false;
		button.value = label;
	}
}

function submitAndWait()
{
	var startButton = document.getElementById("start");
	startButton.disabled=true;
	startButton.value = i18n.please_wait;
	return true;
}

function focusErrorFromHTML()
{
	var errorDiv = document.querySelector('.inputerror');
	if(errorDiv)
	{
		var errorInput = document.getElementById(errorDiv.getAttribute('data-fieldid'));
		errorInput.focus();
		errorInput.select();
	}
}

function setUpListeners()
{
	document.forms['mainform'].addEventListener('submit', submitAndWait);
	document.getElementById('from_url').addEventListener('click', pasteFieldsFromUrl);
	document.getElementById('resetdate').addEventListener('click', setFormDateToToday);
	['lang', 'project', 'tld'].forEach(function(id) {
		document.getElementById(id).addEventListener('input', function() {
			document.getElementById('wiki_paths').value = '';
		});
	});
	var scanAmountIds = ['skipversions', 'ignorefirst', 'limit', 'linear', 'int'];
	for(var i = 0; i < scanAmountIds.length; ++i)
	{
		document.getElementById(scanAmountIds[i]).addEventListener('change', checkScanAmount);
	}
	focusErrorFromHTML();
}

document.addEventListener('DOMContentLoaded', setUpListeners);
window.addEventListener('load', checkScanAmount);
