# Diagrammes UML - Système de Gestion des Rendez-vous Médicaux

Ce dossier contient l'ensemble des diagrammes UML du projet en langage PlantUML (@startuml).

## 📋 Liste des Diagrammes

### 1. **01_Context_Diagram.puml**
- Diagramme de Contexte (C4 Model)
- Acteurs: Patient, Médecin, Secrétaire, Responsable Prestation
- Systèmes externes: Service Email, Base de Données

### 2. **02_Class_Diagram.puml**
- Diagramme de Classes complet
- 9 entités: User, Patient, Medecin, RendezVous, Consultation, Ordonnance, Medicament, OrdonnanceMedicament, Prestation
- Relations: associations, dépendances, multiplicités

### 3. **03_Sequence_Consultation.puml**
- Diagramme de Séquence: Flux de Consultation
- Étapes: Création → Validation → Complétation → Notification → Impression

### 4. **04_Sequence_Prestation.puml**
- Diagramme de Séquence: Flux de Prestation
- Étapes: Création → Validation → Exécution → Notification → Consultation

### 5. **05_Sequence_Cancellation.puml**
- Diagramme de Séquence: Flux d'Annulation
- Vérifications de conditions (délai >48h, statut valide)

### 6. **06_UseCase_Diagram.puml**
- Diagramme de Cas d'Usage
- 13 cas d'usage répartis entre 4 acteurs
- Inclusions et dépendances entre cas

### 7. **07_State_Diagram.puml**
- Diagramme d'État
- États du RendezVous: en_attente → valide → effectue/annule
- Transitions et conditions

### 8. **08_Activity_Consultation_Flow.puml**
- Diagramme d'Activité
- Flux détaillé d'une consultation avec décisions et parallélisation

### 9. **09_Architecture_Diagram.puml**
- Diagramme d'Architecture en Couches
- Couches: Présentation, Application, Métier, Données
- Composants: Controllers, Models, Services, Database

### 10. **10_Roles_Permissions_Matrix.puml**
- Matrice des Rôles et Permissions
- 4 rôles avec permissions détaillées

### 11. **11_Interaction_Diagram.puml**
- Diagramme d'Interaction
- Flux principal avec branchements (consultation vs prestation)

### 12. **12_Deployment_Diagram.puml**
- Diagramme de Déploiement
- Infrastructure: navigateur, serveur, base de données, services

## 🚀 Compilation des Diagrammes

### Option 1: PlantUML en ligne
1. Visitez https://www.plantuml.com/plantuml/uml/
2. Collez le contenu d'un fichier .puml
3. Le diagramme s'affiche automatiquement

### Option 2: PlantUML localement
```bash
# Installation (Ubuntu/Debian)
sudo apt install plantuml

# Génération d'une image
plantuml chemin/vers/fichier.puml

# Les formats supportés: PNG, SVG, PDF, etc.
plantuml -tsvg chemin/vers/fichier.puml
```

### Option 3: VS Code Extension
1. Installez l'extension "PlantUML" (author: jebbs)
2. Ouvrez un fichier .puml
3. Utilisez le preview (Alt+D)

### Option 4: Génération en masse
```bash
# Générer tous les diagrammes en PNG
for file in *.puml; do plantuml "$file"; done

# Générer tous en SVG
for file in *.puml; do plantuml -tsvg "$file"; done
```

## 📐 Structure de Nommage

Les fichiers sont numérotés pour faciliter la lecture:

- **01-12**: Ordre logique de présentation
- **Préfixe**: Type de diagramme (Context, Class, Sequence, UseCase, State, Activity, Architecture, Deployment)
- **.puml**: Extension PlantUML standard

## 💡 Notes d'implémentation

- **Langage**: PlantUML 1.2024.x
- **Syntaxe**: @startuml / @enduml
- **Diagrammes inclus**: UML 2.5 standard
- **Modèle C4**: Utilisé pour le diagramme de contexte

## 🔄 Mise à jour des Diagrammes

Pour mettre à jour un diagramme lors de changements au projet:

1. Modifier le fichier .puml concerné
2. Recompiler (voir section Compilation)
3. Valider visuellement le résultat
4. Commiter les modifications

## 📚 Ressources

- [PlantUML Documentation](https://plantuml.com)
- [UML Standard](https://www.omg.org/uml/)
- [C4 Model](https://c4model.com/)

---

**Généré pour**: Système de Gestion des Rendez-vous Médicaux
**Date**: 16 mai 2026
**Version**: 1.0
