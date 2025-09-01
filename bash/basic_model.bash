#!/bin/bash

# Usage: ./basic_model.sh attribute_to_category

if [ "$#" -lt 1 ]; then
    echo "Usage: $0 table1 table2 ..."
    exit 1
fi

to_camel_case() {
    local input="$1"
    local output=""
    IFS="_" read -ra parts <<< "$input"
    for part in "${parts[@]}"; do
        output+=$(tr '[:lower:]' '[:upper:]' <<< "${part:0:1}")${part:1}
    done
    echo "$output"
}

singularize() {
    local field_name="$1"
    local output
    local len=${#field_name}

    if [[ ! "$field_name" =~ s$ ]]; then
        # Already singular
        output="$field_name"
    elif [[ "$field_name" =~ ss$ ]]; then
        # Ends with 'ss' (e.g., mass, chess)
        output="$field_name"
    elif [[ "$field_name" =~ ies$ ]]; then
        # Ends with 'ies' (e.g., cherries, ladies)
        output="${field_name%ies}y"
    elif [[ "$field_name" =~ oes$ ]]; then
        # Ends with 'oes' (e.g., heroes, potatoes)
        output="${field_name%es}"
    elif [[ "$field_name" =~ es$ ]]; then
        local third_last_char="${field_name: -3:1}"
        case "$third_last_char" in
            [aeiou])
                output="${field_name%s}"
                ;;
            h)
                output="${field_name%es}"
                ;;
            [bcdfgjklmnpqrstvwxyz])
                output="${field_name%s}"
                ;;
            *)
                output="${field_name%s}"
                ;;
        esac
    else
        output="${field_name%s}"
    fi

    echo "$output"
}

singularize_last_word() {
    local input="$1"
    IFS="_" read -ra parts <<< "$input"
    local len=${#parts[@]}
    if [ "$len" -eq 0 ]; then
        echo "$input"
        return
    fi
    local last_index=$((len - 1))
    local last="${parts[$last_index]}"
    last=$(singularize "$last")
    parts[$last_index]="$last"
    echo "${parts[*]}" | tr ' ' '_'
}


for table in "$@"; do
    singular=$(singularize_last_word "$table")
    class_name=$(to_camel_case "$singular")

    cmd="php artisan infyom:scaffold $class_name --fromTable --table=$table --skip=controllers,views,requests,routes,menu"
    $cmd
done
