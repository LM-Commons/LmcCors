<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace LmcCors\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * CorsOptions
 *
 * @license MIT
 * @author  Florent Blaison <florent.blaison@gmail.com>
 */
class CorsOptions extends AbstractOptions
{
    const ROUTE_PARAM = 'cors';

    /**
     * Set the list of allowed origins domain with protocol.
     *
     * @var array
     */
    protected array $allowedOrigins = [];

    /**
     * Set the list of HTTP verbs.
     *
     * @var array
     */
    protected array $allowedMethods = [];

    /**
     * Set the list of headers.
     *
     * @var array
     */
    protected array $allowedHeaders = [];

    /**
     * Set the max age of the authorize request in seconds.
     *
     * @var int
     */
    protected int $maxAge = 0;

    /**
     * Set the list of exposed headers.
     *
     * @var array
     */
    protected array $exposedHeaders = [];

    /**
     * Allow CORS request with credential.
     *
     * @var bool
     */
    protected bool $allowedCredentials = false;

    /**
     * @param  array $allowedOrigins
     * @return void
     */
    public function setAllowedOrigins(array $allowedOrigins): void
    {
        $this->allowedOrigins = $allowedOrigins;
    }

    /**
     * @return array
     */
    public function getAllowedOrigins(): array
    {
        return $this->allowedOrigins;
    }

    /**
     * @param  array $allowedMethods
     * @return void
     */
    public function setAllowedMethods(array $allowedMethods): void
    {
        foreach ($allowedMethods as &$allowedMethod) {
            $allowedMethod = strtoupper($allowedMethod);
        }

        $this->allowedMethods = $allowedMethods;
    }

    /**
     * @return array
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }

    /**
     * @param  array $allowedHeaders
     * @return void
     */
    public function setAllowedHeaders(array $allowedHeaders): void
    {
        $this->allowedHeaders = $allowedHeaders;
    }

    /**
     * @return array
     */
    public function getAllowedHeaders(): array
    {
        return $this->allowedHeaders;
    }

    /**
     * @param int $maxAge
     * @return void
     */
    public function setMaxAge(int $maxAge): void
    {
        $this->maxAge = (int) $maxAge;
    }

    /**
     * @return int
     */
    public function getMaxAge(): int
    {
        return $this->maxAge;
    }

    /**
     * @param  array $exposedHeaders
     * @return void
     */
    public function setExposedHeaders(array $exposedHeaders): void
    {
        $this->exposedHeaders = $exposedHeaders;
    }

    /**
     * @return array
     */
    public function getExposedHeaders(): array
    {
        return $this->exposedHeaders;
    }

    /**
     * @param bool $allowedCredentials
     * @return void
     */
    public function setAllowedCredentials(bool $allowedCredentials): void
    {
        $this->allowedCredentials = (bool) $allowedCredentials;
    }

    /**
     * @return boolean
     */
    public function getAllowedCredentials(): bool
    {
        return $this->allowedCredentials;
    }
}
