# Database Design

## Table `tour_categories`

- id
- name
- updated_at
- created_at

## Table `tours`

- id
- category_id
- name
- description
- cover_image
- updated_at
- created_at

## Table `tour_properties`

- id
- tour_id
- started_date
- vehicle
- amount
- price
- status
- updated_at
- created_at

## Table `tour_timetables`

- id
- tour_id
- name
- description
- updated_at
- created_at
