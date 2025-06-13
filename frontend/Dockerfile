FROM node:lts-alpine3.22


# Set working directory
WORKDIR /var/www/app

# Copy package files for dependency caching
COPY package.json package-lock.json ./

# Install dependencies
RUN npm i -g @vue/cli && npm install

# Copy application code
COPY . .

RUN npm run build

# Expose port (default for Vite, adjust if needed)
EXPOSE 3000

# Run development server
CMD ["npm", "run", "dev"]