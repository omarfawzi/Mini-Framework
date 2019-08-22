# Mini-framework

A Mini-Framework implemented built over docker .

# Build Image

`make build`

# Start Container

`make up`

# Stop Container

`make down`

# Routes

Routes are built to handle dynamic variables with\without Regex :

- `hello/{id}/guest/{name}` : the `id` and `name` variable matches any literals .
- `hello/{(\d+)}/guest/{(\w+)} : here the `first` variable matches only integers while the second variable matches [A-Za-z0-9]

**Note** : when using regex in routes you must group variables using `(` and `)` .
