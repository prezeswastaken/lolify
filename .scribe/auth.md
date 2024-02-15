# Authenticating requests

To authenticate requests, include an **`Authorization`** header with the value **`"Bearer {JWT_ACCESS_TOKEN}"`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

JWT token can be accquired by using /api/login endpoint. It returns JWT token that expires in one hour.
