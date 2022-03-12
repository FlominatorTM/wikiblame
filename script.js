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
	if (versionsToSkipDuring>0)
	{
		expectedVersionsToQuery = expectedVersionsToQuery / versionsToSkipDuring;
	}

	if (
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
function pasteFieldsFromUrl(e)
{
	e.preventDefault();
	var mediaWikiUrl = window.prompt(i18n.paste_url, '');
	if(mediaWikiUrl==null) return;
	var a = document.createElement('a');
	a.href=mediaWikiUrl;

	var hostParts = (a.hostname).split('.');
	var article;
	var language;
	var tld;
	var project;

	// possible cases or URL form:
	// subdomain/language + host + TLD
	// -> http(s)://de.wikipedia.org/whatever
	// host + .org (2 parts)
	// -> http(s)://somewiki.org/whatever
	// host + custom TLD (2 parts)
	// -> http(s)://otherwiki.com/whatever
	// if there are only 2 parts, it's definitely the subdomain that is missing
	if(hostParts.length==3)
	{
		language = hostParts[0];
		project = hostParts[1];
		tld = hostParts[2];
	}
	if(hostParts.length==2)
	{
		language = 'blank';
		project = hostParts[0];
		tld = hostParts[1];
	}

	var titleFound = false;
	var slashWiki = '/wiki/';
	var titleEquals = 'title=';
	if(mediaWikiUrl.search(titleEquals)>0)
	{
		// find article name from a URL like https://example.com/w/index.php?title=Main_Page
		var urlParts = mediaWikiUrl.split('?');

		if(urlParts.length==2)
		{
			var paramParts = urlParts[1].split('&');
			// gets article name from first instance of 'title='
			// @TODO: should probably be last instance to comply with HTTP standard
			for (var i=0; i<paramParts.length; i++)
			{
				if(paramParts[i].startsWith(titleEquals))
				{
					article = decodeURIComponent(paramParts[i].substr(titleEquals.length)).replace(/_/gm, ' ');
					titleFound = true;
					break;
				}
			}
		}
	}
	else if(a.pathname.startsWith(slashWiki))
	{
		// find article name from a URL like https://example.com/wiki/Main_Page
		article = decodeURIComponent(a.pathname.substr(slashWiki.length)).replace(/_/gm, ' ');
		titleFound = true;
	}

	if(!titleFound)
	{
		alert(i18n.no_valid_url);
	}
	else
	{
		document.forms['mainform'].elements['lang'].value=language;
		document.forms['mainform'].elements['project'].value=project;
		document.forms['mainform'].elements['article'].value=article;
		document.forms['mainform'].elements['tld'].value=tld;
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
	if (errorDiv) {
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
	var scanAmountIds = ['skipversions', 'ignorefirst', 'limit', 'linear', 'int'];
	for (var i = 0; i < scanAmountIds.length; ++i) {
		document.getElementById(scanAmountIds[i]).addEventListener('change', checkScanAmount);
	}
	focusErrorFromHTML();
}

document.addEventListener('DOMContentLoaded', setUpListeners);
window.addEventListener('load', checkScanAmount);
