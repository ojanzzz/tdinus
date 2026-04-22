# Git Merge origin/main to local main

## Steps:
- [ ] Stop running git show command (user: Ctrl+C in terminal)
- [x] Fetch origin (done)
- [ ] Run `git merge origin/main --allow-unrelated-histories -X ours`
- [ ] Check `git status`, add conflicted files if any
- [ ] `git commit -m "Merge origin/main --allow-unrelated-histories, prefer local changes"`
- [ ] `git push origin main`
- [ ] Verify with `git status` and `git log --graph --oneline -10`
- [ ] Test project (artisan migrate if new, etc.)
