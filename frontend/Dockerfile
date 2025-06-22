FROM node:22 AS build

WORKDIR /var/www/app
COPY ./frontend/package*.json ./
RUN npm i
RUN npm i -g @vue/cli
COPY ./frontend/. .
RUN npm run build

ENV PORT=5173
EXPOSE 5173

CMD ["npm","run","serve"]

# COPY ./frontend/package*.json ./
# RUN npm i -g @vue/cli
# RUN npm i
# COPY ./frontend/. .
# RUN npm run build

# FROM nginx:alpine
# COPY --from=build /var/www/app/dist /usr/share/nginx/html
# COPY ./nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
# EXPOSE 80
