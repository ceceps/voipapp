FROM node:lts-alpine3.22 AS build

# Set working directory
WORKDIR /var/www/app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install -g @vue/cli \
    && npm install
	
RUN export PATH="$PATH:node_modules/.bin"

# Copy the rest of the application
COPY . .

# Build the Vue app for production
RUN npm run build

# Use Nginx to serve the built files
FROM nginx:alpine

# Set timezone
ENV TZ=Asia/Jakarta

# Install bash for debugging
RUN apk add --no-cache bash

# Copy built files from the build stage
COPY --from=build /var/www/app/dist /usr/share/nginx/html/crm

# Expose port
EXPOSE 80

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]