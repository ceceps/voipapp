FROM node:24 AS build


RUN addgroup app && adduser -S -G app app
USER app

WORKDIR /var/www/app
COPY ./frontend/package*.json ./
RUN npm ci
COPY ./frontend/* .
RUN npm i -g @vue/cli
RUN npm run build

ENV PORT=5173
EXPOSE 5173

CMD ["npm","run","serve"]
# FROM nginx:alpine AS release
# COPY --from=build /var/www/app/dist /var/www/app/dist
# COPY ./nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
# EXPOSE 80

# CMD [ "nginx","-g","daemon off;"]

