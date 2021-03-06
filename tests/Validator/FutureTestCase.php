<?php
/*
 *  $Id$
 *
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
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
 */

/**
 * Doctrine_Validator_FutureTestCase
 *
 * @package     Doctrine
 * @author      Roman Borschel <roman@code-factory.org>
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @category    Object Relational Mapping
 * @link        www.doctrine-project.org
 * @since       1.0
 * @version     $Revision$
 */
class Doctrine_Validator_Future_TestCase extends Doctrine_UnitTestCase
{
    public function prepareTables()
    {
        $this->tables[] = 'ValidatorTest_DateModel';
        parent::prepareTables();
    }

    public function prepareData()
    {
        
    }
    
    public function testValidFutureDates()
    {
        $this->manager->setAttribute(Doctrine_Core::ATTR_VALIDATE, Doctrine_Core::VALIDATE_ALL);
        
        // one year ahead
        $user1 = new ValidatorTest_DateModel();
        $user1->death = date('Y-m-d', time() + 365 * 24 * 60 * 60);
        $this->assertTrue($user1->trySave());
        
        // one month ahead
        $user1 = new ValidatorTest_DateModel();
        $user1->death = date('Y-m-d', time() + 30 * 24 * 60 * 60);
        $this->assertTrue($user1->trySave());
        
        // one day ahead
        $user1->death = date('Y-m-d', time() + 24 * 60 * 60);
        $this->assertTrue($user1->trySave());
        
        $this->manager->setAttribute(Doctrine_Core::ATTR_VALIDATE, Doctrine_Core::VALIDATE_NONE);
    }
    
    public function testInvalidFutureDates()
    {
        $this->manager->setAttribute(Doctrine_Core::ATTR_VALIDATE, Doctrine_Core::VALIDATE_ALL);

        $user1 = new ValidatorTest_DateModel();
        $user1->death = date('Y-m-d', 42);
        $this->assertFalse($user1->trySave());
        
        $user1->death = date('Y-m-d', time());
        $this->assertFalse($user1->trySave());
        
        $user1->death = date('Y-m-d', time() + 60);
        $this->assertFalse($user1->trySave());
        
        $this->manager->setAttribute(Doctrine_Core::ATTR_VALIDATE, Doctrine_Core::VALIDATE_NONE);
    }

}
