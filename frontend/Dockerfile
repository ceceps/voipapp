FROM node:lts-alpine3.22 AS base

# Set working directory

ENV PNPM_HOME="/pnpm"
ENV PATH="$PNPM_HOME:$PATH"
RUN corepack enable
COPY . /var/www/app
WORKDIR /var/www/app

FROM base AS prod-deps
RUN --mount=type=cache,id=pnpm,target=/pnpm/store pnpm install --prod --frozen-lockfile

FROM base AS build
RUN --mount=type=cache,id=pnpm,target=/pnpm/store pnpm install --frozen-lockfile
RUN pnpm run build

FROM base
COPY --from=prod-deps /var/www/app/node_modules /var/www/app/node_modules
COPY --from=build /var/www/app/dist /var/www/app/dist
EXPOSE 5137
CMD [ "pnpm", "serve" ]
