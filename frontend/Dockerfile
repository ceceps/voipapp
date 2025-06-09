FROM node:lts-alpine3.22

# Set working directory

WORKDIR /var/www/app
 
COPY package.json package.json
 
RUN npm i -g @vue/cli \
    && npm i @vue/cli-service \
    && npm install
 
COPY . . 

EXPOSE 5137

CMD [ "node", "run", "serve" ]