# Test cases in order to detect regressions
## Binary search
### Search for deletion
* [with removal of sure revisions, present in earliest](http://wikipedia.ramselehof.de/wikiblame.php?user_lang=de&lang=de&project=wikipedia&article=Europ%C3%A4ischer_Stabilit%C3%A4tsmechanismus&needle=eraltet%7Cseit%3D2013%7Cdes+Artikels%7CHat+d&skipversions=0&ignorefirst=0&limit=500&offtag=21&offmon=10&offjahr=2017&searchmethod=int&order=desc&binary_search_inverse=on&force_wikitags=on&user=)
* [with removal of sure revisions, inserted later = not present in earliest](http://wikipedia.ramselehof.de/wikiblame.php?user_lang=ru&lang=ru&project=wikipedia&article=%D0%A3%D1%87%D0%B0%D1%81%D1%82%D0%BD%D0%B8%D0%BA%3AJack_who_built_the_house%2Fcopy_wikilinks.js&needle=refactor&skipversions=0&ignorefirst=0&limit=100&offtag=25&offmon=4&offjahr=2016&searchmethod=int&order=desc&binary_search_inverse=on&user=)
