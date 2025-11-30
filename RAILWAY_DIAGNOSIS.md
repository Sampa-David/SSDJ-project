# 🔍 DIAGNOSTIC ERREUR 500 - RAILWAY

**Date**: 30 novembre 2025  
**Statut**: ❌ ERREUR IDENTIFIÉE

---

## 📊 ANALYSE DE L'ERREUR

### **Erreur Principale**
```
PDOException(code: 2002): SQLSTATE[HY000] [2002]
Aucune connexion n'a pu être établie car l'ordinateur cible l'a expressément refusée
```

### **Localisation de l'Erreur**
- **Fichier**: `storage/logs/laravel.log`
- **Commande qui a échoué**: `php artisan migrate`
- **Cause**: Connexion MySQL impossible

---

## 🔴 PROBLÈME IDENTIFIÉ

**Railway utilise une architecture Docker en conteneurs** :
- ✅ LOCAL: `DB_HOST=127.0.0.1` → fonctionne (MySQL sur votre machine)
- ❌ RAILWAY: `DB_HOST=127.0.0.1` → n'existe pas (c'est un conteneur Docker!)

**Votre .env.production** utilise des valeurs **incorrectes** :
```
DB_HOST=ssdj-db          ✅ CORRECT (nom du service Railway)
DB_USERNAME=root         ❌ INCORRECT (devrait être 'railway')
DB_PASSWORD=railway      ⚠️  À CONFIRMER
```

---

## ✅ SOLUTION ÉTAPE PAR ÉTAPE

### **Étape 1: Vérifier la Configuration Railway**

Allez sur **Railway Dashboard** :
1. Cliquez sur votre service **web**
2. Allez dans **Settings** → **Config**
3. Vérifiez ces variables :

| Variable | Valeur Actuelle | Valeur Correcte |
|----------|---|---|
| DB_HOST | ? | `ssdj-db` |
| DB_PORT | ? | `3306` |
| DB_DATABASE | ? | `ssdj` |
| DB_USERNAME | ? | `railway` |
| DB_PASSWORD | ? | `railway` |
| SESSION_DRIVER | ? | `database` |
| CACHE_DRIVER | ? | `database` |

### **Étape 2: Corriger `.env.production`**

Remplacer les valeurs de base de données :

```dotenv
# ❌ AVANT (INCORRECT)
DB_HOST=ssdj-db
DB_USERNAME=root
DB_PASSWORD=railway

# ✅ APRÈS (CORRECT)
DB_HOST=ssdj-db
DB_USERNAME=railway
DB_PASSWORD=railway
```

### **Étape 3: Vérifier le Start Command**

Sur Railway Dashboard :
1. Service **web** → **Deploy Logs**
2. Cherchez le **Start Command**
3. Doit être: `sh ./bin/start.sh` (NON `php -S 0.0.0.0:8080...`)

### **Étape 4: Redéployer**

1. Railway Dashboard → **Redeploy**
2. Attendre la fin du build
3. Vérifier les logs de déploiement

### **Étape 5: Tester**

Après redéploiement:
- Allez sur `https://[votre-app].up.railway.app/`
- Si vous voyez la page d'accueil → ✅ PROBLÈME RÉSOLU
- Si erreur 500 → Vérifier les logs Railway

---

## 🔧 COMMANDES À EXÉCUTER EN LOCAL

```bash
# 1. Tester la connexion BD locale
mysql -h 127.0.0.1 -u SSDJ_USER -proot -D ssdj -e "SELECT COUNT(*) FROM users;"

# 2. Vider le cache Laravel
php artisan cache:clear

# 3. Reconstruire la config
php artisan config:clear

# 4. Tester l'app locale
php artisan serve
```

---

## 📋 CHECKLIST DE CORRECTION

- [ ] Vérifier variables DATABASE sur Railway Dashboard
- [ ] Corriger DB_USERNAME si besoin (devrait être `railway` pas `root`)
- [ ] Mettre à jour Start Command vers `sh ./bin/start.sh`
- [ ] Commit et Push les changements
- [ ] Redéployer sur Railway
- [ ] Vérifier HTTP 200 (pas 500)
- [ ] Tester l'accès aux pages

---

## ❓ QUESTIONS FRÉQUENTES

**Q: Pourquoi 127.0.0.1 ne marche pas sur Railway?**  
A: Railway utilise Docker. Les conteneurs ne peuvent pas accéder à localhost. Il faut utiliser le nom du service (`ssdj-db`).

**Q: Quelle est la différence entre `root` et `railway`?**  
A: `root` est l'admin MySQL global. `railway` est l'utilisateur créé pour votre app. Vérifiez sur Railway.

**Q: Vais-je perdre mes données en redéployant?**  
A: Non! Votre base de données Railway persiste indépendamment de l'app.

**Q: Combien de temps pour que ça reparte?**  
A: Redéploiement: ~2-3 minutes. Les migrations se relanceront automatiquement.

