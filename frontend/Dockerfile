FROM node:22 AS build

WORKDIR /var/www/app
# COPY package*.json ./
# RUN npm ci
# RUN npm i -g @vue/cli
# COPY . .
# RUN npm run build

# ENV PORT=5173
# EXPOSE 5173

# CMD ["npm","run","serve"]

COPY package*.json ./
RUN npm i -g @vue/cli
RUN npm ci
COPY . .
RUN npm run build

FROM nginx:alpine
COPY --from=build /var/www/app/dist /usr/share/nginx/html
EXPOSE 80