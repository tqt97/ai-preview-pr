# 📦 AI PR Review CLI

An AI-powered **Pull Request Review Engine** for PHP (FuelPHP / legacy codebase), designed to analyze git changes, build execution context, detect impact, and generate structured AI review input for Gemini CLI.

---

## 🚀 Overview

This tool transforms a simple git diff into a **structured AI review package**, enabling LLMs to act like a senior PHP architect reviewing your PR.

Instead of sending raw code to AI, it builds:

* Change context
* Dependency graph
* Call relationships
* Risk analysis
* Architecture hints

Then generates a **clean AI-ready markdown package**.

---

## 🧠 Core Idea

> Git Diff → Static Analysis → Context Builder → AI Prompt Package → Gemini Review

---

## 🔄 Full Flow Architecture

```text
1. Git Diff Layer
   ↓
2. PHP Parser (token_get_all)
   ↓
3. Call Graph Builder
   ↓
4. Context Builder (Impact Analysis)
   ↓
5. Package Builder (AI Prompt Generator)
   ↓
6. Gemini CLI
   ↓
7. AI Review Result
```

---

## 📂 Project Structure

```text
ai-pr-review/
│
├── review.php                  ## CLI entry point
├── config/
│   └── config.php             ## configuration
│
├── src/
│   ├── Autoloader.php
│   ├── Bootstrap.php
│   ├── Application.php
│
│   ├── Git/
│   │   ├── GitService.php
│   │   └── GitDiff.php
│
│   ├── Parser/
│   │   ├── PhpParser.php
│   │   └── Model/
│   │       ├── ParsedFile.php
│   │       ├── ParsedClass.php
│   │       ├── ParsedMethod.php
│   │       └── Call.php
│
│   ├── Analyzer/
│   │   ├── CallGraph.php
│   │   └── DependencyAnalyzer.php
│
│   ├── Context/
│   │   ├── Context.php
│   │   └── ContextBuilder.php
│
│   ├── Package/
│   │   ├── Package.php
│   │   └── PackageBuilder.php
│
│   ├── Console/
│   │   └── Console.php
│
│   ├── Support/
│   │   └── Logger.php
│
│   └── AI/
│       └── GeminiClient.php
│
└── review/
    ├── package.md             ## AI input
    └── result.md             ## AI output
```

---

## ⚙️ Requirements

* PHP 8.1+
* Git CLI
* Gemini CLI installed

```bash
npm install -g @google/gemini-cli
```

---

## ▶️ Usage

### Run review

```bash
php review.php release /home/user/projects/my-fuel-app
```

or

```bash
php review.php dev /home/user/projects/my-fuel-app
```

---

### Output

#### Step 1 — Context Analysis

* Changed files
* Affected classes
* Related dependencies
* Risk classification

---

#### Step 2 — AI Package generation

File:

```text
review/package.md
```

Contains:

* Git diff summary
* Architecture context
* Dependency graph
* Risk signals
* Review rules

---

#### Step 3 — AI Review (Gemini)

Automatically runs:

```bash
gemini -f review/package.md
```

Output:

```text
review/result.md
```

---

## 🧩 Key Features

### 1. Git-Aware Analysis

* Detects changed branches
* Extracts modified files
* Normalizes FuelPHP structure

---

### 2. PHP Static Parsing (token-based)

* Class detection
* Method extraction
* Namespace parsing
* No Composer dependency

---

### 3. Dependency Graph

* Controller → Service → Repository → Model flow tracking
* Basic call relationship mapping
* Cross-class interaction detection

---

### 4. Context Builder (Impact Analysis)

Automatically detects:

* Affected classes
* Related methods
* Risk zones:

  * API changes
  * Business logic changes
  * Database layer changes

---

### 5. AI Prompt Builder

Generates structured AI input with:

* Strict review rules
* Architecture constraints
* Change context
* Risk signals

---

### 6. Gemini Integration

Fully automated AI review pipeline:

```bash
git diff → analysis → AI → review output
```

---

## 🏗 Architecture Philosophy

This project is built with:

* ❌ No framework dependency
* ❌ No Composer required
* ❌ No heavy reflection
* ❌ No runtime magic

Instead:

* ✔ token_get_all() parsing
* ✔ deterministic analysis
* ✔ explicit flow control
* ✔ lightweight CLI design

---

## 🧠 Design Principles

### 1. Incremental Analysis

Only analyzes:

* Changed files
* Related dependencies
* Impacted nodes

No full-project scan.

---

### 2. FuelPHP Friendly

Supports:

```text
Controller_User_Apply
Service_Job_Process
Model_User_Profile
```

Mapped from:

```text
classes/controller/user/apply.php
```

---

### 3. AI-first architecture

This tool does NOT replace AI.

It prepares **high-quality structured context for AI reasoning**.

---

## 📊 Output Quality

Instead of:

> raw git diff

AI receives:

```text
- structured change context
- dependency graph
- risk classification
- architecture rules
- execution flow
```

Result:

👉 higher accuracy
👉 fewer hallucinations
👉 better review depth
👉 senior-level feedback

---

## 🔥 Example AI Capability

Detects issues like:

* Controller contains business logic
* Service bypasses repository layer
* Missing validation layer
* SQL performance risk
* Hidden dependency impact
* Regression risk in related modules

---

## 🧪 Example Output Flow

```text
Git Diff Detected
→ 3 files changed

Context Builder
→ 2 controllers affected
→ 1 service impacted
→ 1 repository touched

Risk Engine
→ BUSINESS_LOGIC_CHANGE
→ API_BEHAVIOR_CHANGE

AI Package Generated
→ review/package.md

Gemini Review
→ review/result.md
```

---

## 📌 Summary

This tool is not just a CLI.

It is a:

> **AI-powered PHP Code Review Engine for legacy systems**
