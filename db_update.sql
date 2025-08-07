-- News
ALTER TABLE news
DROP COLUMN shared_on_facebook;
ALTER TABLE news
DROP COLUMN shared_on_twitter;

-- Article authors
ALTER TABLE article_authors
DROP COLUMN date_of_birth;
ALTER TABLE article_author_descriptions
DROP COLUMN title;
