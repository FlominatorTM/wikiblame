# wikipedia_shared_includes

shared functions used by other repositories starting with "wikipedia_"

Adding this as subtree to another project
=========================================
1. create remote:
git remote add -f shared_inc https://github.com/FlominatorTM/wikipedia_shared_includes
(f only does a fetch immeditely afterwards)

2. add subtree:
git subtree add --prefix shared_inc shared_inc master 

3. fetch changes after some time:
git fetch shared_inc
git subtree pull --prefix shared_inc shared_inc master --squash
(squash prevents "merging by history")

4. push back to origin of subtree
git subtree push --prefix=shared_inc shared_inc master
