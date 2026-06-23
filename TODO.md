# TODO - Redirection dashboards

- [ ] Modifier `routes/web.php` pour que la route `/dashboard` redirige tout le monde vers la page `statistics.index` sauf le patient.
- [ ] Créer une nouvelle route patient `statistics`/dashboard patient si nécessaire (pour le vrai dashboard patient).
- [ ] Mettre à jour le sidebar si elle pointe encore vers l’ancienne route `dashboard`.
- [ ] Vérifier que les middlewares/roles autorisent l’accès à la page stats pour `medecin` et `secretaire`.
- [ ] Lancer un test manuel : login patient vs secrétaire/médecin/responsable.

