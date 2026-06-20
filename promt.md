# Load all review standards from this project.

Read in this order:

00_SYSTEM

10_CONTEXT

20_RULES

30_PROMPTS

Then perform a full Pull Request Review.

Review phases:

1. Requirement Validation

2. Business Logic Review

3. Architecture Review

4. PHP Best Practices

5. FuelPHP Best Practices

6. SQL Review

7. Performance Review

8. Security Review

9. Regression Analysis

10. Duplicate Logic Detection

11. Production Readiness

12. Final Recommendation

Rules:

- Never assume missing context.
- If context is insufficient, explicitly list the exact files or methods required before making conclusions.
- Prioritize correctness over style.
- Explain every finding with:
  - Evidence
  - Impact
  - Recommendation
- Classify issues as Critical, Major, Minor, or Suggestion.
- End with an overall score and merge recommendation.